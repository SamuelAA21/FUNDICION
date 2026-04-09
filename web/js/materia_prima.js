var tablaMateriaPrima = null;

$(document).ready(function () {
    listMateriaPrima();
});

var listMateriaPrima = function () {
    tablaMateriaPrima = $("#tblMateriaPrima").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=MateriaPrima&controller=MateriaPrima&function=data",
            method: "GET"
        },
        columns: [
            { data: "mat_codigo" },
            { data: "mat_descripcion" },
            { data: "mat_peligrosidad" },
            { data: "tmetal_descripcion" },
            { data: "ematp_descripcion" },
            { data: "pres_descripcion" },
            { data: "corr_id" },
            { data: "bod_descripcion" },
            { data: "tpel_descripcion" },
            { data: "pro_nombre" },
            { data: "mat_estado" },
            { data: "acciones" }
        ]
    });
};

window.materiaPrimaNuevo = function () {
    $("#frmMateriaPrima")[0].reset();
    $("#mat_codigo_original").val("");
    $("#mat_codigo").prop("readonly", false);
    $("#modalMateriaPrimaTitle").text("Nueva Materia Prima");
    $("#modalMateriaPrima").modal("show");
};

window.materiaPrimaGuardar = function () {
    $.ajax({
        url: URL_MP_SAVE,
        type: "POST",
        data: $("#frmMateriaPrima").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (r.ok) {
            $("#modalMateriaPrima").modal("hide");
            tablaMateriaPrima.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.materiaPrimaEditar = function (mat_codigo) {
    $.ajax({
        url: URL_MP_ONE,
        type: "POST",
        data: { mat_codigo: mat_codigo },
        dataType: "json"
    }).done(function (r) {
        $("#mat_codigo_original").val(r.mat_codigo || "");
        $("#mat_codigo").val(r.mat_codigo || "").prop("readonly", true);
        $("#mat_descripcion").val(r.mat_descripcion || "");
        $("#mat_peligrosidad").val(r.mat_peligrosidad || "");
        $("#tmetal_id").val(r.tmetal_id || "");
        $("#ematp_id").val(r.ematp_id || "");
        $("#pres_id").val(r.pres_id || "");
        $("#corr_id").val(r.corr_id || "");
        $("#bod_id").val(r.bod_id || "");
        $("#tpel_id").val(r.tpel_id || "");
        $("#pro_id").val(r.pro_id || "");
        $("#mat_estado").val(r.mat_estado || "Activo");
        $("#modalMateriaPrimaTitle").text("Editar Materia Prima");
        $("#modalMateriaPrima").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar la materia prima", "error");
    });
};

window.materiaPrimaEliminar = function (mat_codigo) {
    swal({
        title: "Eliminar materia prima?",
        text: "Codigo: " + mat_codigo,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_MP_DEL,
            type: "POST",
            data: { mat_codigo: mat_codigo },
            dataType: "json"
        }).done(function (r) {
            if (r.ok) {
                tablaMateriaPrima.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
