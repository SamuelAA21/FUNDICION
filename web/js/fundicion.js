document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('frmFundicion');
    var btnLimpiar = document.getElementById('btnLimpiarFundicion');
    var inputFecha = document.getElementById('fun_fecha');
    var inputNumero = document.getElementById('fun_numero');
    var selectHorno = document.getElementById('fun_horno');
    var inputCombustibleTipo = document.getElementById('fun_combustible_tipo');

    function fechaActualISO() {
        return new Date().toISOString().split('T')[0];
    }

    function syncDatalistInput(inputId, listId, hiddenId) {
        var input = document.getElementById(inputId);
        var list = document.getElementById(listId);
        var hidden = document.getElementById(hiddenId);

        if (!input || !list || !hidden) {
            return;
        }

        function resolveValue() {
            var value = input.value.trim().toLowerCase();
            hidden.value = '';

            Array.prototype.forEach.call(list.options, function (option) {
                if (option.value.trim().toLowerCase() === value) {
                    hidden.value = option.dataset.id || '';
                }
            });
        }

        input.addEventListener('input', resolveValue);
        input.addEventListener('change', resolveValue);
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

    syncDatalistInput('fun_materia_prima', 'listMateriasPrimas', 'fun_mat_codigo');
    syncDatalistInput('fun_cliente', 'listClientes', 'fun_cliente_id');
    syncDatalistInput('fun_producto_terminado', 'listProductos', 'fun_producto_id');

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
