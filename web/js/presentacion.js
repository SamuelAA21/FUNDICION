var tablaPresentacion = null;

$(document).ready(function () {
    listPresentacion();
});

var listPresentacion = function () {
    tablaPresentacion = $("#tblPresentacion").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=Presentacion&controller=Presentacion&function=data",
            method: "GET"
        },
        columns: [
            { data: "pres_id" },
            { data: "pres_descripcion" },
            { data: "pres_estado" },
            { data: "acciones" }
        ]
    });
};

window.presentacionNuevo = function () {
    $("#frmPresentacion")[0].reset();
    $("#pres_id_original").val("");
    $("#pres_id_catalogo").prop("readonly", false);
    $("#modalPresentacionTitle").text("Nueva Presentacion");
    $("#modalPresentacion").modal("show");
};

window.presentacionGuardar = function () {
    $.ajax({
        url: URL_PRES_SAVE,
        type: "POST",
        data: $("#frmPresentacion").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (r.ok) {
            $("#modalPresentacion").modal("hide");
            tablaPresentacion.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.presentacionEditar = function (pres_id) {
    $.ajax({
        url: URL_PRES_ONE,
        type: "POST",
        data: { pres_id: pres_id },
        dataType: "json"
    }).done(function (r) {
        $("#pres_id_original").val(r.pres_id || "");
        $("#pres_id_catalogo").val(r.pres_id || "").prop("readonly", true);
        $("#pres_descripcion_catalogo").val(r.pres_descripcion || "");
        $("#pres_estado_catalogo").val(r.pres_estado || "Activo");
        $("#modalPresentacionTitle").text("Editar Presentacion");
        $("#modalPresentacion").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar la presentacion", "error");
    });
};

window.presentacionEliminar = function (pres_id) {
    swal({
        title: "Eliminar presentacion?",
        text: "ID: " + pres_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_PRES_DEL,
            type: "POST",
            data: { pres_id: pres_id },
            dataType: "json"
        }).done(function (r) {
            if (r.ok) {
                tablaPresentacion.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
