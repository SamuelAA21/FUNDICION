var tablaCombustible = null;

$(document).ready(function () {
    listCombustible();

    $(document).on("click", ".btn-edit", function () {
        combustibleEditar($(this).data("id"));
    });

    $(document).on("click", ".btn-delete", function () {
        combustibleEliminar($(this).data("id"));
    });
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
            url: "ajax.php?module=Combustible&controller=Combustible&function=data&t=" + Date.now(),
            method: "GET",
            dataSrc: "data"
        },
        columns: [
            { data: "comb_id", defaultContent: "" },
            { data: "comb_descripcion", defaultContent: "" },
            { data: "comb_estado", defaultContent: "Inactivo" },
            {
                data: "acciones",
                defaultContent: "",
                orderable: false,
                searchable: false
            }
        ]
    });
};

window.combustibleNuevo = function () {
    $("#frmCombustible")[0].reset();
    $("#comb_id").val("");
    $("#modalCombustibleTitle").text("Nuevo Combustible");
    $("#modalCombustible").modal("show");
};

window.combustibleGuardar = function () {
    if ($("#comb_descripcion").val().trim() === "") {
        swal("Error", "La descripcion es obligatoria", "error");
        return;
    }

    var url = ($("#comb_id").val() === "") ? URL_COMBUSTIBLE_POSTNEW : URL_COMBUSTIBLE_UPDATE;

    $.ajax({
        url: url,
        type: "POST",
        data: $("#frmCombustible").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (!r || typeof r.ok === "undefined") {
            swal("Error", "Respuesta invalida del servidor", "error");
            return;
        }

        if (r.ok) {
            $("#modalCombustible").modal("hide");
            tablaCombustible.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.combustibleEditar = function (comb_id) {
    $.ajax({
        url: URL_COMBUSTIBLE_ONE,
        type: "POST",
        data: { comb_id: comb_id },
        dataType: "json"
    }).done(function (r) {
        if (!r || !r.com_id) {
            swal("Error", "No se pudo cargar el combustible", "error");
            return;
        }

        $("#comb_id").val(r.com_id || "");
        $("#comb_descripcion").val(r.com_descripcion || "");
        $("#comb_estado").val((r.com_estado == 0 || String(r.com_estado).toLowerCase() === "inactivo") ? "0" : "1");
        $("#modalCombustibleTitle").text("Editar Combustible");
        $("#modalCombustible").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar el combustible", "error");
    });
};

window.combustibleEliminar = function (comb_id) {
    swal({
        title: "Eliminar combustible?",
        text: "ID: " + comb_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_COMBUSTIBLE_DELETE,
            type: "POST",
            data: { comb_id: comb_id },
            dataType: "json"
        }).done(function (r) {
            if (!r || typeof r.ok === "undefined") {
                swal("Error", "Respuesta invalida del servidor", "error");
                return;
            }

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
};
