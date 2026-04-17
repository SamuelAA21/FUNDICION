var tablaBodega = null;

$(document).ready(function () {
    listBodega();

    $(document).on("click", ".btn-edit", function () {
        bodegaEditar($(this).data("id"));
    });

    $(document).on("click", ".btn-delete", function () {
        bodegaEliminar($(this).data("id"));
    });
});

var listBodega = function () {
    tablaBodega = $("#tblBodega").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=Bodega&controller=Bodega&function=data&t=" + Date.now(),
            method: "GET",
            dataSrc: "data"
        },
        columns: [
            { data: "bod_id", defaultContent: "" },
            { data: "bod_descripcion", defaultContent: "" },
            { data: "bod_capacidad", defaultContent: "" },
            { data: "bod_area", defaultContent: "" },
            { data: "bod_estado", defaultContent: "Inactivo" },
            {
                data: "acciones",
                defaultContent: "",
                orderable: false,
                searchable: false
            }
        ]
    });
};

window.bodegaNuevo = function () {
    $("#frmBodega")[0].reset();
    $("#bod_id_catalogo").prop("readonly", false);
    $("#modalBodegaTitle").text("Nueva Bodega");
    $("#modalBodega").modal("show");
};

window.bodegaGuardar = function () {
    if ($("#bod_id_catalogo").val() === "" || $("#bod_descripcion").val().trim() === "" || $("#bod_capacidad").val().trim() === "" || $("#bod_area").val().trim() === "") {
        swal("Error", "Complete los campos obligatorios", "error");
        return;
    }

    var isNew = $("#bod_id_catalogo").prop("readonly") === false;
    var url = isNew ? URL_BOD_POSTNEW : URL_BOD_UPDATE;

    $.ajax({
        url: url,
        type: "POST",
        data: $("#frmBodega").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (!r || typeof r.ok === "undefined") {
            swal("Error", "Respuesta invalida del servidor", "error");
            return;
        }

        if (r.ok) {
            $("#modalBodega").modal("hide");
            tablaBodega.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.bodegaEditar = function (bod_id) {
    $.ajax({
        url: URL_BOD_ONE,
        type: "POST",
        data: { bod_id: bod_id },
        dataType: "json"
    }).done(function (r) {
        if (!r || !r.bod_id) {
            swal("Error", "No se pudo cargar la bodega", "error");
            return;
        }

        $("#bod_id_catalogo").val(r.bod_id || "").prop("readonly", true);
        $("#bod_descripcion").val(r.bod_descripcion || "");
        $("#bod_capacidad").val(r.bod_capacidad || "");
        $("#bod_area").val(r.bod_area || "");
        $("#bod_estado").val(r.bod_estado || "Activo");
        $("#modalBodegaTitle").text("Editar Bodega");
        $("#modalBodega").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar la bodega", "error");
    });
};

window.bodegaEliminar = function (bod_id) {
    swal({
        title: "Eliminar bodega?",
        text: "ID: " + bod_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_BOD_DELETE,
            type: "POST",
            data: { bod_id: bod_id },
            dataType: "json"
        }).done(function (r) {
            if (!r || typeof r.ok === "undefined") {
                swal("Error", "Respuesta invalida del servidor", "error");
                return;
            }

            if (r.ok) {
                tablaBodega.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
