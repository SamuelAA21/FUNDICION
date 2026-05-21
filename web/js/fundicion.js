$(document).ready(function () {
    var form = document.getElementById('frmFundicion');
    var btnLimpiar = document.getElementById('btnLimpiarFundicion');
    var inputFecha = document.getElementById('fun_fecha');
    var inputNumero = document.getElementById('fun_numero');
    var selectHorno = document.getElementById('fun_horno');
    var inputCombustibleTipo = document.getElementById('fun_combustible_tipo');
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

            initComplete: function (settings, json) {
                renderizarGraficaFundicion(json.data);
            }
        });

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
