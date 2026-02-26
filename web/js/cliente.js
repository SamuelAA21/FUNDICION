
var tablaClientes = null;

$(document).ready(function () {
    listCliente();
});

var tablaClientes = null;

var listCliente = function () {
    tablaClientes = $("#tblClientes").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        lengthChange: false,
        pageLength: 15,
        autoWidth: true,
        ajax: {
            url: "ajax.php?module=Cliente&controller=Cliente&function=data",
            method: "GET" // o "POST" si tú lo manejas así
        },
        deferRender: true,
        columns: [
            { data: "cli_nit" },
            { data: "cli_razon_social" },
            { data: "cli_dir" },
            { data: "cli_tel" },
            { data: "cli_correo" },
            { data: "cli_nombre_contacto" },
            { data: "cli_estado" },
            { data: "acciones" }
        ]
    });
};


window.clienteNuevo = function () {

    $("#frmCliente")[0].reset();

    $("#cli_nit").prop("readonly", false);

    $("#modalClienteTitle").text("Nuevo Cliente");

    $("#modalCliente").modal("show");
}

window.clienteGuardar = function () {

    $.ajax({
        url: URL_CLIENTE_SAVE,
        type: "POST",
        data: $("#frmCliente").serialize(),
        dataType: "json"
    }).done(function (r) {

        if (r.ok) {
            $("#modalCliente").modal("hide");
            tablaClientes.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }

    }).fail(function () {
        swal("Error", "Fallo la petición al servidor", "error");
    });

}

window.clienteEditar = function(cli_nit) {

    $.ajax({
        url: URL_CLIENTE_ONE,
        type: "POST",
        data: { cli_nit: cli_nit },
        dataType: "json"
    }).done(function (r) {

        $("#cli_nit").val(r.cli_nit || "");
        $("#cli_razon_social").val(r.cli_razon_social || "");
        $("#cli_dir").val(r.cli_dir || "");
        $("#cli_tel").val(r.cli_tel || "");
        $("#cli_correo").val(r.cli_correo || "");
        $("#cli_nombre_contacto").val(r.cli_nombre_contacto || "");
        $("#cli_estado").val(r.cli_estado || "Activo");

        $("#cli_nit").prop("readonly", true);

        $("#modalClienteTitle").text("Editar Cliente");

        $("#modalCliente").modal("show");

    }).fail(function () {
        swal("Error", "No se pudo cargar el cliente", "error");
    });

}

window.clienteEliminar = function(cli_nit) {

    swal({
        title: "¿Eliminar cliente?",
        text: "NIT: " + cli_nit,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {

        if (!ok) return;

        $.ajax({
            url: URL_CLIENTE_DEL,
            type: "POST",
            data: { cli_nit: cli_nit },
            dataType: "json"
        }).done(function (r) {

            if (r.ok) {
                tablaClientes.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }

        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });

    });

}