var tablaRecepcionResiduos = null;

$(document).ready(function () {
    listRecepcionResiduos();
});

function toDatetimeLocal(value) {
    if (!value) return "";
    return value.replace(" ", "T").substring(0, 16);
}

var listRecepcionResiduos = function () {
    tablaRecepcionResiduos = $("#tblRecepcionResiduos").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=RecepcionResiduos&controller=RecepcionResiduos&function=data",
            method: "GET"
        },
        columns: [
            { data: "rres_id" },
            { data: "rres_fecha_doc" },
            { data: "rres_fecha_recepcion" },
            { data: "cli_razon_social" },
            { data: "rres_transportador" },
            { data: "tvehi_descripcion" },
            { data: "rres_placa" },
            { data: "rres_total" },
            { data: "tmanejo_descripcion" },
            { data: "rres_peligro" },
            { data: "rres_estado" },
            { data: "acciones" }
        ]
    });
};

window.recepcionResiduosNuevo = function () {
    $("#frmRecepcionResiduos")[0].reset();
    $("#rres_id").prop("readonly", false);
    $("#modalRecepcionResiduosTitle").text("Nueva Recepcion Residuos");
    $("#modalRecepcionResiduos").modal("show");
};

window.recepcionResiduosGuardar = function () {
    $.ajax({
        url: URL_RRES_SAVE,
        type: "POST",
        data: $("#frmRecepcionResiduos").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (r.ok) {
            $("#modalRecepcionResiduos").modal("hide");
            tablaRecepcionResiduos.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.recepcionResiduosEditar = function (rres_id) {
    $.ajax({
        url: URL_RRES_ONE,
        type: "POST",
        data: { rres_id: rres_id },
        dataType: "json"
    }).done(function (r) {
        $("#rres_id").val(r.rres_id || "").prop("readonly", true);
        $("#rres_fecha_doc").val(toDatetimeLocal(r.rres_fecha_doc));
        $("#rres_fecha_recepcion").val(r.rres_fecha_recepcion || "");
        $("#rr_cli_nit").val(r.cli_nit || "");
        $("#rres_transportador").val(r.rres_transportador || "");
        $("#tvehi_id").val(r.tvehi_id || "");
        $("#rres_placa").val(r.rres_placa || "");
        $("#rres_recomendaciones").val(r.rres_recomendaciones || "");
        $("#rr_usu_crea").val(r.usu_crea || "");
        $("#rres_total").val(r.rres_total || 0);
        $("#tmanejo_id").val(r.tmanejo_id || "");
        $("#rres_peligro").val(r.rres_peligro || "");
        $("#rres_codigo_qr").val(r.rres_codigo_qr || "");
        $("#rres_estado").val(r.rres_estado || "Activo");
        $("#rr_usu_anula").val(r.usu_anula || "");
        $("#fecha_anula").val(toDatetimeLocal(r.fecha_anula));
        $("#razon_anula").val(r.razon_anula || "");
        $("#modalRecepcionResiduosTitle").text("Editar Recepcion Residuos");
        $("#modalRecepcionResiduos").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar la recepcion", "error");
    });
};

window.recepcionResiduosEliminar = function (rres_id) {
    swal({
        title: "Eliminar recepcion de residuos?",
        text: "ID: " + rres_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_RRES_DEL,
            type: "POST",
            data: { rres_id: rres_id },
            dataType: "json"
        }).done(function (r) {
            if (r.ok) {
                tablaRecepcionResiduos.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
