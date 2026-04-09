var tablaTipoManejo = null;

$(document).ready(function () {
    listTipoManejo();
});

var listTipoManejo = function () {
    tablaTipoManejo = $("#tblTipoManejo").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=TipoManejo&controller=TipoManejo&function=data",
            method: "GET"
        },
        columns: [
            { data: "tmanejo_id" },
            { data: "tmanejo_descripcion" },
            { data: "tmanejo_estado" },
            { data: "acciones" }
        ]
    });
};

window.tipoManejoNuevo = function () {
    $("#frmTipoManejo")[0].reset();
    $("#tmanejo_id_original").val("");
    $("#tmanejo_id_catalogo").prop("readonly", false);
    $("#modalTipoManejoTitle").text("Nuevo Tipo Manejo");
    $("#modalTipoManejo").modal("show");
};

window.tipoManejoGuardar = function () {
    $.ajax({
        url: URL_TMAN_SAVE,
        type: "POST",
        data: $("#frmTipoManejo").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (r.ok) {
            $("#modalTipoManejo").modal("hide");
            tablaTipoManejo.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.tipoManejoEditar = function (tmanejo_id) {
    $.ajax({
        url: URL_TMAN_ONE,
        type: "POST",
        data: { tmanejo_id: tmanejo_id },
        dataType: "json"
    }).done(function (r) {
        $("#tmanejo_id_original").val(r.tmanejo_id || "");
        $("#tmanejo_id_catalogo").val(r.tmanejo_id || "").prop("readonly", true);
        $("#tmanejo_descripcion_catalogo").val(r.tmanejo_descripcion || "");
        $("#tmanejo_estado_catalogo").val(r.tmanejo_estado || "Activo");
        $("#modalTipoManejoTitle").text("Editar Tipo Manejo");
        $("#modalTipoManejo").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar el tipo de manejo", "error");
    });
};

window.tipoManejoEliminar = function (tmanejo_id) {
    swal({
        title: "Eliminar tipo de manejo?",
        text: "ID: " + tmanejo_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_TMAN_DEL,
            type: "POST",
            data: { tmanejo_id: tmanejo_id },
            dataType: "json"
        }).done(function (r) {
            if (r.ok) {
                tablaTipoManejo.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
