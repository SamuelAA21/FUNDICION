var tablaEstadoMateria = null;

$(document).ready(function () {
    listEstadoMateria();
});

var listEstadoMateria = function () {
    tablaEstadoMateria = $("#tblEstadoMateria").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=EstadoMateria&controller=EstadoMateria&function=data",
            method: "GET"
        },
        columns: [
            { data: "ematp_id" },
            { data: "ematp_descripcion" },
            { data: "acciones" }
        ]
    });
};

window.estadoMateriaNuevo = function () {
    $("#frmEstadoMateria")[0].reset();
    $("#ematp_id_original").val("");
    $("#ematp_id_catalogo").prop("readonly", false);
    $("#modalEstadoMateriaTitle").text("Nuevo Estado Materia");
    $("#modalEstadoMateria").modal("show");
};

window.estadoMateriaGuardar = function () {
    $.ajax({
        url: URL_EM_SAVE,
        type: "POST",
        data: $("#frmEstadoMateria").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (r.ok) {
            $("#modalEstadoMateria").modal("hide");
            tablaEstadoMateria.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.estadoMateriaEditar = function (ematp_id) {
    $.ajax({
        url: URL_EM_ONE,
        type: "POST",
        data: { ematp_id: ematp_id },
        dataType: "json"
    }).done(function (r) {
        $("#ematp_id_original").val(r.ematp_id || "");
        $("#ematp_id_catalogo").val(r.ematp_id || "").prop("readonly", true);
        $("#ematp_descripcion_catalogo").val(r.ematp_descripcion || "");
        $("#modalEstadoMateriaTitle").text("Editar Estado Materia");
        $("#modalEstadoMateria").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar el estado de materia", "error");
    });
};

window.estadoMateriaEliminar = function (ematp_id) {
    swal({
        title: "Eliminar estado de materia?",
        text: "ID: " + ematp_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_EM_DEL,
            type: "POST",
            data: { ematp_id: ematp_id },
            dataType: "json"
        }).done(function (r) {
            if (r.ok) {
                tablaEstadoMateria.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
