var tablaDetalleFundicion = null;

$(document).ready(function () {
    listDetalleFundicion();
});

var listDetalleFundicion = function () {
    tablaDetalleFundicion = $("#tblDetalleFundicion").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=DetalleFundicion&controller=DetalleFundicion&function=data",
            method: "GET"
        },
        columns: [
            { data: "dfun_id" },
            { data: "rfun_id" },
            { data: "mat_descripcion" },
            { data: "cli_razon_social" },
            { data: "dfun_cantidad" },
            { data: "pro_nombre" },
            { data: "hor_descripcion" },
            { data: "com_descripcion" },
            { data: "dfun_per_metal" },
            { data: "dfun_num_docrres" },
            { data: "acciones" }
        ]
    });
};

window.detalleFundicionNuevo = function () {
    $("#frmDetalleFundicion")[0].reset();
    $("#dfun_id_original").val("");
    $("#dfun_id").prop("readonly", false);
    $("#modalDetalleFundicionTitle").text("Nuevo Detalle Fundicion");
    $("#modalDetalleFundicion").modal("show");
};

window.detalleFundicionGuardar = function () {
    $.ajax({
        url: URL_DFUN_SAVE,
        type: "POST",
        data: $("#frmDetalleFundicion").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (r.ok) {
            $("#modalDetalleFundicion").modal("hide");
            tablaDetalleFundicion.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.detalleFundicionEditar = function (dfun_id) {
    $.ajax({
        url: URL_DFUN_ONE,
        type: "POST",
        data: { dfun_id: dfun_id },
        dataType: "json"
    }).done(function (r) {
        $("#dfun_id_original").val(r.dfun_id || "");
        $("#dfun_id").val(r.dfun_id || "").prop("readonly", true);
        $("#rfun_id").val(r.rfun_id || "");
        $("#df_mat_codigo").val(r.mat_codigo || "");
        $("#Cli_mat").val(r.Cli_mat || "");
        $("#dfun_cantidad").val(r.dfun_cantidad || 0);
        $("#df_pro_id").val(r.pro_id || "");
        $("#dfun_cantprot").val(r.dfun_cantprot || 0);
        $("#esc_id").val(r.esc_id || 0);
        $("#dfun_cantesc").val(r.dfun_cantesc || 0);
        $("#df_hor_id").val(r.hor_id || "");
        $("#df_com_id").val(r.com_id || "");
        $("#dfun_cantidad_com").val(r.dfun_cantidad_com || 0);
        $("#dfun_hinicio").val(r.dfun_hinicio || "");
        $("#dfun_hfin").val(r.dfun_hfin || "");
        $("#dfun_per_metal").val(r.dfun_per_metal || 0);
        $("#dfun_num_docrres").val(r.dfun_num_docrres || 0);
        $("#modalDetalleFundicionTitle").text("Editar Detalle Fundicion");
        $("#modalDetalleFundicion").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar el detalle", "error");
    });
};

window.detalleFundicionEliminar = function (dfun_id) {
    swal({
        title: "Eliminar detalle fundicion?",
        text: "ID: " + dfun_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_DFUN_DEL,
            type: "POST",
            data: { dfun_id: dfun_id },
            dataType: "json"
        }).done(function (r) {
            if (r.ok) {
                tablaDetalleFundicion.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
