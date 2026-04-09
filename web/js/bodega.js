var tablaBodega = null;

$(document).ready(function () {
    listBodega();
});

var listBodega = function () {
    tablaBodega = $("#tblBodega").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=Bodega&controller=Bodega&function=data",
            method: "GET"
        },
        columns: [
            { data: "bod_id" },
            { data: "bod_descripcion" },
            { data: "bod_capacidad" },
            { data: "bod_area" },
            { data: "bod_estado" },
            { data: "acciones" }
        ]
    });
};

window.bodegaNuevo = function () {
    $("#frmBodega")[0].reset();
    $("#bod_id_original").val("");
    $("#bod_id_catalogo").prop("readonly", false);
    $("#modalBodegaTitle").text("Nueva Bodega");
    $("#modalBodega").modal("show");
};

window.bodegaGuardar = function () {
    $.ajax({
        url: URL_BOD_SAVE,
        type: "POST",
        data: $("#frmBodega").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (r.ok) {
            $("#modalBodega").modal("hide");
            tablaBodega.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.bodegaEditar = function (bod_id) {
    $.ajax({
        url: URL_BOD_ONE,
        type: "POST",
        data: { bod_id: bod_id },
        dataType: "json"
    }).done(function (r) {
        $("#bod_id_original").val(r.bod_id || "");
        $("#bod_id_catalogo").val(r.bod_id || "").prop("readonly", true);
        $("#bod_descripcion").val(r.bod_descripcion || "");
        $("#bod_capacidad").val(r.bod_capacidad || "");
        $("#bod_area").val(r.bod_area || "");
        $("#bod_estado").val(r.bod_estado || "Activo");
        $("#modalBodegaTitle").text("Editar Bodega");
        $("#modalBodega").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar la bodega", "error");
    });
};

window.bodegaEliminar = function (bod_id) {
    swal({
        title: "Eliminar bodega?",
        text: "ID: " + bod_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_BOD_DEL,
            type: "POST",
            data: { bod_id: bod_id },
            dataType: "json"
        }).done(function (r) {
            if (r.ok) {
                tablaBodega.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
