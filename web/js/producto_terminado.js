var tablaProductoTerminado = null;

$(document).ready(function () {
    listProductoTerminado();
});

var listProductoTerminado = function () {
    tablaProductoTerminado = $("#tblProductoTerminado").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=ProductoTerminado&controller=ProductoTerminado&function=data",
            method: "GET"
        },
        columns: [
            { data: "pro_id" },
            { data: "pro_nombre" },
            { data: "tmetal_descripcion" },
            { data: "pres_descripcion" },
            { data: "bod_descripcion" },
            { data: "pro_estado" },
            { data: "acciones" }
        ]
    });
};

window.productoTerminadoNuevo = function () {
    $("#frmProductoTerminado")[0].reset();
    $("#pro_id").prop("readonly", false);
    $("#modalProductoTerminadoTitle").text("Nuevo Producto Terminado");
    $("#modalProductoTerminado").modal("show");
};

window.productoTerminadoGuardar = function () {
    $.ajax({
        url: URL_PT_SAVE,
        type: "POST",
        data: $("#frmProductoTerminado").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (r.ok) {
            $("#modalProductoTerminado").modal("hide");
            tablaProductoTerminado.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.productoTerminadoEditar = function (pro_id) {
    $.ajax({
        url: URL_PT_ONE,
        type: "POST",
        data: { pro_id: pro_id },
        dataType: "json"
    }).done(function (r) {
        $("#pro_id").val(r.pro_id || "").prop("readonly", true);
        $("#pro_nombre").val(r.pro_nombre || "");
        $("#pt_tmetal_id").val(r.tmetal_id || "");
        $("#pt_pres_id").val(r.pres_id || "");
        $("#pt_bod_id").val(r.bod_id || "");
        $("#pro_estado").val(r.pro_estado || "Activo");
        $("#modalProductoTerminadoTitle").text("Editar Producto Terminado");
        $("#modalProductoTerminado").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar el producto", "error");
    });
};

window.productoTerminadoEliminar = function (pro_id) {
    swal({
        title: "Eliminar producto terminado?",
        text: "ID: " + pro_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_PT_DEL,
            type: "POST",
            data: { pro_id: pro_id },
            dataType: "json"
        }).done(function (r) {
            if (r.ok) {
                tablaProductoTerminado.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
