var tablaCombustible = null;

$(document).ready(function () {
    listCombustible();
});

var listCombustible = function () {
    tablaCombustible = $("#tblCombustible").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=Combustible&controller=Combustible&function=data",
            method: "GET"
        },
        deferRender: true,
        columns: [
            { data: "comb_id" },
            { data: "comb_descripcion" },
            { data: "comb_estado" },
            { data: "acciones" }
        ]
    });
};

window.combustibleNuevo = function () {

    $("#frmCombustible")[0].reset();

    $("#comb_id").val("");

    $("#modalCombustibleTitle").text("Nuevo Combustible");

    $("#modalCombustible").modal("show");
}

window.combustibleGuardar = function () {

    $.ajax({
        url: URL_COMBUSTIBLE_SAVE,
        type: "POST",
        data: $("#frmCombustible").serialize(),
        dataType: "json"
    }).done(function (r) {

        if (r.ok) {
            $("#modalCombustible").modal("hide");
            tablaCombustible.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }

    }).fail(function () {
        swal("Error", "Fallo la petición al servidor", "error");
    });

}

window.combustibleEditar = function(comb_id) {

    $.ajax({
        url: URL_COMBUSTIBLE_ONE,
        type: "POST",
        data: { comb_id: comb_id },
        dataType: "json"
    }).done(function (r) {

        $("#comb_id").val(r.comb_id || "");
        $("#comb_descripcion").val(r.comb_descripcion || "");
        $("#comb_estado").val((r.comb_estado == 0) ? "0" : "1");

        $("#modalCombustibleTitle").text("Editar Combustible");

        $("#modalCombustible").modal("show");

    }).fail(function () {
        swal("Error", "No se pudo cargar el combustible", "error");
    });

}

window.combustibleEliminar = function(comb_id) {

    swal({
        title: "¿Eliminar combustible?",
        text: "ID: " + comb_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {

        if (!ok) return;

        $.ajax({
            url: URL_COMBUSTIBLE_DEL,
            type: "POST",
            data: { comb_id: comb_id },
            dataType: "json"
        }).done(function (r) {

            if (r.ok) {
                tablaCombustible.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }

        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });

    });

}