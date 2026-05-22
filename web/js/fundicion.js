$(document).ready(function () {
    var form = document.getElementById('frmFundicion');
    var btnLimpiar = document.getElementById('btnLimpiarFundicion');
    var inputFecha = document.getElementById('fun_fecha');
    var inputNumero = document.getElementById('fun_numero');
    var selectHorno = document.getElementById('fun_horno');
    var inputCombustibleTipo = document.getElementById('fun_combustible_tipo');
    var inputBuscarFundicion = document.getElementById('txtBuscarFundicion');
    var inputFechaDesdeFundicion = document.getElementById('txtFechaDesdeFundicion');
    var inputFechaHastaFundicion = document.getElementById('txtFechaHastaFundicion');
    var btnBuscarFundicion = document.getElementById('btnBuscarFundicion');
    var btnLimpiarBusquedaFundicion = document.getElementById('btnLimpiarBusquedaFundicion');
    var tablaFundicionReporte = null;

    function crearGraficaColumnas(data) {
        Highcharts.chart(data.container, {
            chart: {
                type: 'column'
            },

            title: {
                text: data.titulo
            },

            subtitle: {
                text: data.subtitulo || ''
            },

            xAxis: {
                categories: data.categorias,
                crosshair: true
            },

            yAxis: {
                min: 0,
                title: {
                    text: data.tituloY
                }
            },

            tooltip: {
                valueSuffix: data.sufijoTooltip || ''
            },

            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },

            series: data.series
        });
    }

    function renderizarGraficaFundicion(registros) {
        var acumulado = {};
        var categorias;
        var serieMateriaPrima = [];
        var serieProducto = [];
        var serieResiduo = [];

        if (!Array.isArray(registros) || !registros.length) {
            crearGraficaColumnas({
                container: 'graficaFundicionProducto',
                titulo: 'Produccion por producto',
                subtitulo: 'Sin datos para los filtros aplicados',
                categorias: [],
                tituloY: 'Cantidad total',
                sufijoTooltip: ' und',
                series: [
                    { name: 'Materia prima', data: [] },
                    { name: 'Producto terminado', data: [] },
                    { name: 'Residuo', data: [] }
                ]
            });
            return;
        }

        registros.forEach(function (item) {
            var producto = item.pro_nombre || 'Sin producto';

            if (!acumulado[producto]) {
                acumulado[producto] = {
                    materiaPrima: 0,
                    productoTerminado: 0,
                    residuo: 0,

                };
            }

            acumulado[producto].materiaPrima += parseFloat(item.dfun_cantidad || 0);
            acumulado[producto].productoTerminado += parseFloat(item.dfun_cantprot || 0);
            acumulado[producto].residuo += parseFloat(item.dfun_cantesc || 0);

        });

        categorias = Object.keys(acumulado);

        categorias.forEach(function (producto) {
            serieMateriaPrima.push(Number(acumulado[producto].materiaPrima.toFixed(2)));
            serieProducto.push(Number(acumulado[producto].productoTerminado.toFixed(2)));
            serieResiduo.push(Number(acumulado[producto].residuo.toFixed(2)));
        });

        crearGraficaColumnas({
            container: 'graficaFundicionProducto',
            titulo: 'Produccion por producto',
            subtitulo: 'Comparativo de materia prima, producto terminado, y residuo',
            categorias: categorias,
            tituloY: 'Cantidad total',
            sufijoTooltip: ' und',
            series: [
                {
                    name: 'Materia prima',
                    data: serieMateriaPrima
                },
                {
                    name: 'Producto terminado',
                    data: serieProducto
                },
                {
                    name: 'Residuo',
                    data: serieResiduo
                },
            ]
        });
    }

    function actualizarGraficaDesdeTabla() {
        var registrosFiltrados = [];
        var datosTabla;

        if (!tablaFundicionReporte) {
            return;
        }

        datosTabla = tablaFundicionReporte.rows({ filter: 'applied' }).data();

        if (datosTabla && typeof datosTabla.toArray === 'function') {
            registrosFiltrados = datosTabla.toArray();
        }

        renderizarGraficaFundicion(registrosFiltrados);
    }

    function normalizarTexto(valor) {
        return String(valor == null ? '' : valor)
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '');
    }

    function registroCumpleFiltroFecha(registro, fechaDesde, fechaHasta) {
        var fechaRegistro = registro && registro.rfun_fecha ? String(registro.rfun_fecha) : '';

        if (fechaRegistro === '') {
            return !fechaDesde && !fechaHasta;
        }

        if (fechaDesde && fechaRegistro < fechaDesde) {
            return false;
        }

        if (fechaHasta && fechaRegistro > fechaHasta) {
            return false;
        }

        return true;
    }

    function ejecutarBusquedaReporte() {
        var terminoBusqueda = '';

        if (!tablaFundicionReporte) {
            return;
        }

        if (inputBuscarFundicion) {
            terminoBusqueda = inputBuscarFundicion.value || '';
        }

        tablaFundicionReporte.search(terminoBusqueda).draw();
    }

    function limpiarBusquedaReporte() {
        if (inputBuscarFundicion) {
            inputBuscarFundicion.value = '';
        }

        if (inputFechaDesdeFundicion) {
            inputFechaDesdeFundicion.value = '';
        }

        if (inputFechaHastaFundicion) {
            inputFechaHastaFundicion.value = '';
        }

        if (tablaFundicionReporte) {
            tablaFundicionReporte.search('').draw();
        }
    }

    function inicializarReporte() {
        if (typeof $ === 'undefined' || !$.fn.DataTable || !$('#tblFundicionReporte').length || typeof URL_FUNDICION_DATA === 'undefined') {
            return;
        }

        tablaFundicionReporte = $('#tblFundicionReporte').DataTable({
            destroy: true,
            responsive: true,
            searching: true,
            ordering: false,
            pageLength: 10,
            autoWidth: false,
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copy', text: 'Copiar' },
                { extend: 'excel', text: 'Excel', title: 'Reporte_Fundicion' },
                { extend: 'pdf', text: 'PDF', title: 'Reporte_Fundicion' },
                { extend: 'print', text: 'Imprimir', title: 'Reporte de Fundicion' }
            ],
            ajax: {
                url: URL_FUNDICION_DATA + '&t=' + Date.now(),
                method: 'GET',
                dataSrc: 'data'
            },
            columns: [
                { data: 'rfun_id', defaultContent: '' },
                { data: 'rfun_fecha', defaultContent: '' },
                { data: 'responsable', defaultContent: '' },
                { data: 'mat_descripcion', defaultContent: '' },
                { data: 'dfun_cantidad', defaultContent: '' },
                { data: 'cli_razon_social', defaultContent: '' },
                { data: 'pro_nombre', defaultContent: '' },
                { data: 'dfun_cantprot', defaultContent: '' },
                { data: 'dfun_cantesc', defaultContent: '' },
                { data: 'hor_descripcion', defaultContent: '' },
                { data: 'com_descripcion', defaultContent: '' },
                { data: 'dfun_cantidad_com', defaultContent: '' },
                { data: 'horario', defaultContent: '' },
                { data: 'dfun_per_metal', defaultContent: '' },
                { data: 'rfun_observacion', defaultContent: '' }
            ],

            initComplete: function () {
                actualizarGraficaDesdeTabla();
            },

            drawCallback: function () {
                actualizarGraficaDesdeTabla();
            }
        });

        if ($.fn.dataTable && $.fn.dataTable.ext && $.fn.dataTable.ext.search) {
            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var fechaDesde = inputFechaDesdeFundicion ? (inputFechaDesdeFundicion.value || '') : '';
                var fechaHasta = inputFechaHastaFundicion ? (inputFechaHastaFundicion.value || '') : '';
                var registro;

                if (!tablaFundicionReporte || settings.nTable !== tablaFundicionReporte.table().node()) {
                    return true;
                }

                if (!fechaDesde && !fechaHasta) {
                    return true;
                }

                registro = tablaFundicionReporte.row(dataIndex).data();

                return registroCumpleFiltroFecha(registro, fechaDesde, fechaHasta);
            });
        }

        $('#btnFundicionCopiar').off('click').on('click', function () {
            tablaFundicionReporte.button('.buttons-copy').trigger();
        });

        $('#btnFundicionExcel').off('click').on('click', function () {
            tablaFundicionReporte.button('.buttons-excel').trigger();
        });

        $('#btnFundicionPdf').off('click').on('click', function () {
            tablaFundicionReporte.button('.buttons-pdf').trigger();
        });

        $('#btnFundicionImprimir').off('click').on('click', function () {
            tablaFundicionReporte.button('.buttons-print').trigger();
        });

        if (btnBuscarFundicion) {
            btnBuscarFundicion.addEventListener('click', function () {
                ejecutarBusquedaReporte();
            });
        }

        if (btnLimpiarBusquedaFundicion) {
            btnLimpiarBusquedaFundicion.addEventListener('click', function () {
                limpiarBusquedaReporte();
            });
        }

        if (inputBuscarFundicion) {
            inputBuscarFundicion.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    ejecutarBusquedaReporte();
                }
            });
        }
    }

    function fechaActualISO() {
        return new Date().toISOString().split('T')[0];
    }

    function syncCombustible() {
        if (!selectHorno || !inputCombustibleTipo) {
            return;
        }

        var option = selectHorno.options[selectHorno.selectedIndex];
        inputCombustibleTipo.value = option ? (option.dataset.combustible || '') : '';
    }

    if (inputFecha && !inputFecha.value) {
        inputFecha.value = fechaActualISO();
    }

    inicializarReporte();

    if (selectHorno) {
        selectHorno.addEventListener('change', syncCombustible);
        syncCombustible();
    }

    if (btnLimpiar && form) {
        btnLimpiar.addEventListener('click', function () {
            form.reset();

            ['fun_mat_codigo', 'fun_cliente_id', 'fun_producto_id'].forEach(function (id) {
                var field = document.getElementById(id);
                if (field) {
                    field.value = '';
                }
            });

            if (inputFecha) {
                inputFecha.value = fechaActualISO();
            }

            if (inputNumero && inputNumero.defaultValue) {
                inputNumero.value = inputNumero.defaultValue;
            }

            syncCombustible();
        });
    }

    if (form) {
        form.addEventListener('submit', function (event) {
            var requiredMaps = [
                { hidden: 'fun_mat_codigo', label: 'Materia Prima' },
                { hidden: 'fun_cliente_id', label: 'Cliente' },
                { hidden: 'fun_producto_id', label: 'Producto Terminado' }
            ];

            for (var i = 0; i < requiredMaps.length; i++) {
                var field = document.getElementById(requiredMaps[i].hidden);
                if (field && !field.value) {
                    event.preventDefault();
                    swal('Error', 'Seleccione un valor valido para ' + requiredMaps[i].label, 'error');
                    return;
                }
            }
        });
    }
});
