var tablaTipoMetal = null;

$(document).ready(function () {
    listTipoMetal();
});

var listTipoMetal = function () {
    tablaTipoMetal = $("#tblTipoMetal").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=TipoMetal&controller=TipoMetal&function=data",
            method: "GET"
        },
        columns: [
            { data: "tmetal_id" },
            { data: "tmetal_descripcion" },
            { data: "tmetal_estado" },
            { data: "acciones" }
        ]
    });
};

window.tipoMetalNuevo = function () {
    $("#frmTipoMetal")[0].reset();
    $("#tmetal_id_original").val("");
    $("#tmetal_id").prop("readonly", false);
    $("#modalTipoMetalTitle").text("Nuevo Tipo Metal");
    $("#modalTipoMetal").modal("show");
};

window.tipoMetalGuardar = function () {
    $.ajax({
        url: URL_TM_SAVE,
        type: "POST",
        data: $("#frmTipoMetal").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (r.ok) {
            $("#modalTipoMetal").modal("hide");
            tablaTipoMetal.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.tipoMetalEditar = function (tmetal_id) {
    $.ajax({
        url: URL_TM_ONE,
        type: "POST",
        data: { tmetal_id: tmetal_id },
        dataType: "json"
    }).done(function (r) {
        $("#tmetal_id_original").val(r.tmetal_id || "");
        $("#tmetal_id").val(r.tmetal_id || "").prop("readonly", true);
        $("#tmetal_descripcion").val(r.tmetal_descripcion || "");
        $("#tmetal_estado").val(r.tmetal_estado || "Activo");
        $("#modalTipoMetalTitle").text("Editar Tipo Metal");
        $("#modalTipoMetal").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar el tipo de metal", "error");
    });
};

window.tipoMetalEliminar = function (tmetal_id) {
    swal({
        title: "Eliminar tipo de metal?",
        text: "ID: " + tmetal_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_TM_DEL,
            type: "POST",
            data: { tmetal_id: tmetal_id },
            dataType: "json"
        }).done(function (r) {
            if (r.ok) {
                tablaTipoMetal.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
