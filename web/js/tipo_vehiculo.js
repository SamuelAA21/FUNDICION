var tablaTipoVehiculo = null;

$(document).ready(function () {
    listTipoVehiculo();
});

var listTipoVehiculo = function () {
    tablaTipoVehiculo = $("#tblTipoVehiculo").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=TipoVehiculo&controller=TipoVehiculo&function=data",
            method: "GET"
        },
        columns: [
            { data: "tvehi_id" },
            { data: "tvehi_descripcion" },
            { data: "acciones" }
        ]
    });
};

window.tipoVehiculoNuevo = function () {
    $("#frmTipoVehiculo")[0].reset();
    $("#tvehi_id_original").val("");
    $("#tvehi_id_catalogo").prop("readonly", false);
    $("#modalTipoVehiculoTitle").text("Nuevo Tipo Vehiculo");
    $("#modalTipoVehiculo").modal("show");
};

window.tipoVehiculoGuardar = function () {
    $.ajax({
        url: URL_TV_SAVE,
        type: "POST",
        data: $("#frmTipoVehiculo").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (r.ok) {
            $("#modalTipoVehiculo").modal("hide");
            tablaTipoVehiculo.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.tipoVehiculoEditar = function (tvehi_id) {
    $.ajax({
        url: URL_TV_ONE,
        type: "POST",
        data: { tvehi_id: tvehi_id },
        dataType: "json"
    }).done(function (r) {
        $("#tvehi_id_original").val(r.tvehi_id || "");
        $("#tvehi_id_catalogo").val(r.tvehi_id || "").prop("readonly", true);
        $("#tvehi_descripcion_catalogo").val(r.tvehi_descripcion || "");
        $("#modalTipoVehiculoTitle").text("Editar Tipo Vehiculo");
        $("#modalTipoVehiculo").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar el tipo de vehiculo", "error");
    });
};

window.tipoVehiculoEliminar = function (tvehi_id) {
    swal({
        title: "Eliminar tipo de vehiculo?",
        text: "ID: " + tvehi_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_TV_DEL,
            type: "POST",
            data: { tvehi_id: tvehi_id },
            dataType: "json"
        }).done(function (r) {
            if (r.ok) {
                tablaTipoVehiculo.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
