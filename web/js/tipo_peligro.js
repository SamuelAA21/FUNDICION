var tablaTipoPeligro = null;

$(document).ready(function () {
    listTipoPeligro();
});

var listTipoPeligro = function () {
    tablaTipoPeligro = $("#tblTipoPeligro").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=TipoPeligro&controller=TipoPeligro&function=data",
            method: "GET"
        },
        columns: [
            { data: "tpel_id" },
            { data: "tpel_descripcion" },
            { data: "tpel_especifica" },
            { data: "tpel_estado" },
            { data: "acciones" }
        ]
    });
};

window.tipoPeligroNuevo = function () {
    $("#frmTipoPeligro")[0].reset();
    $("#tpel_id_original").val("");
    $("#tpel_id_catalogo").prop("readonly", false);
    $("#modalTipoPeligroTitle").text("Nuevo Tipo Peligro");
    $("#modalTipoPeligro").modal("show");
};

window.tipoPeligroGuardar = function () {
    $.ajax({
        url: URL_TPEL_SAVE,
        type: "POST",
        data: $("#frmTipoPeligro").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (r.ok) {
            $("#modalTipoPeligro").modal("hide");
            tablaTipoPeligro.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.tipoPeligroEditar = function (tpel_id) {
    $.ajax({
        url: URL_TPEL_ONE,
        type: "POST",
        data: { tpel_id: tpel_id },
        dataType: "json"
    }).done(function (r) {
        $("#tpel_id_original").val(r.tpel_id || "");
        $("#tpel_id_catalogo").val(r.tpel_id || "").prop("readonly", true);
        $("#tpel_descripcion").val(r.tpel_descripcion || "");
        $("#tpel_especifica").val(r.tpel_especifica || "");
        $("#tpel_estado").val(r.tpel_estado || "Activo");
        $("#modalTipoPeligroTitle").text("Editar Tipo Peligro");
        $("#modalTipoPeligro").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar el tipo de peligro", "error");
    });
};

window.tipoPeligroEliminar = function (tpel_id) {
    swal({
        title: "Eliminar tipo de peligro?",
        text: "ID: " + tpel_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_TPEL_DEL,
            type: "POST",
            data: { tpel_id: tpel_id },
            dataType: "json"
        }).done(function (r) {
            if (r.ok) {
                tablaTipoPeligro.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
