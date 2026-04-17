var tablaHorno = null;

$(document).ready(function () {
    listHorno();

    $(document).on("click", ".btn-edit", function () {
        var hor_id = $(this).data("id");
        hornoEditar(hor_id);
    });

    $(document).on("click", ".btn-delete", function () {
        var hor_id = $(this).data("id");
        hornoEliminar(hor_id);
    });
});

var listHorno = function () {
    tablaHorno = $("#tblHorno").DataTable({
        destroy: true,
        responsive: true,
        searching: true,
        ordering: false,
        pageLength: 15,
        autoWidth: false,
        ajax: {
            url: "ajax.php?module=Horno&controller=Horno&function=data&t=" + Date.now(),
            method: "GET",
            dataSrc: "data"
        },
        columns: [
            { data: "hor_id", defaultContent: "" },
            { data: "hor_descripcion", defaultContent: "" },
            { data: "com_descripcion", defaultContent: "Sin combustible" },
            { data: "hor_estado", defaultContent: "Inactivo" },
            {
                data: "acciones",
                defaultContent: "",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    if (data) {
                        return data;
                    }

                    return '<button class="btn btn-sm btn-primary btn-edit" data-id="' + row.hor_id + '">Editar</button> ' +
                        '<button class="btn btn-sm btn-danger btn-delete" data-id="' + row.hor_id + '">Eliminar</button>';
                }
            }
        ]
    });
};

window.hornoNuevo = function () {
    $("#frmHorno")[0].reset();
    $("#hor_id").val("");
    $("#modalHornoTitle").text("Nuevo Horno");
    $("#modalHorno").modal("show");
};

window.hornoGuardar = function () {
    if ($("#hor_descripcion").val().trim() === "") {
        swal("Error", "La descripcion es obligatoria", "error");
        return;
    }

    if (!$("#com_id").val()) {
        swal("Error", "Seleccione un combustible valido", "error");
        return;
    }

    var url = ($("#hor_id").val() === "") ? URL_HORNO_POSTNEW : URL_HORNO_UPDATE;

    $.ajax({
        url: url,
        type: "POST",
        data: $("#frmHorno").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (!r || typeof r.ok === "undefined") {
            swal("Error", "Respuesta invalida del servidor", "error");
            return;
        }

        if (r.ok) {
            $("#modalHorno").modal("hide");
            tablaHorno.ajax.reload(null, false);
            swal("Correcto", r.msg, "success");
        } else {
            swal("Error", r.msg, "error");
        }
    }).fail(function () {
        swal("Error", "Fallo la peticion al servidor", "error");
    });
};

window.hornoEditar = function (hor_id) {
    $.ajax({
        url: URL_HORNO_ONE,
        type: "POST",
        data: { hor_id: hor_id },
        dataType: "json"
    }).done(function (r) {
        if (!r || !r.hor_id) {
            swal("Error", "No se pudo cargar el horno", "error");
            return;
        }

        $("#hor_id").val(r.hor_id || "");
        $("#hor_descripcion").val(r.hor_descripcion || "");
        $("#com_id").val(r.com_id || "");
        $("#hor_estado").val((r.hor_estado == 0 || String(r.hor_estado).toLowerCase() === "inactivo") ? "0" : "1");
        $("#modalHornoTitle").text("Editar Horno");
        $("#modalHorno").modal("show");
    }).fail(function () {
        swal("Error", "No se pudo cargar el horno", "error");
    });
};

window.hornoEliminar = function (hor_id) {
    swal({
        title: "Eliminar horno?",
        text: "ID: " + hor_id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {
        if (!ok) return;

        $.ajax({
            url: URL_HORNO_DELETE,
            type: "POST",
            data: { hor_id: hor_id },
            dataType: "json"
        }).done(function (r) {
            if (!r || typeof r.ok === "undefined") {
                swal("Error", "Respuesta invalida del servidor", "error");
                return;
            }

            if (r.ok) {
                tablaHorno.ajax.reload(null, false);
                swal("Eliminado", r.msg, "success");
            } else {
                swal("Error", r.msg, "error");
            }
        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });
    });
};
