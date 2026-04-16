var tablaTipoMetal = null;

$(document).ready(function () {
    listTipoMetal();

    // Evento para editar
    $(document).on('click', '.btn-edit', function() {
        var tmetal_id = $(this).data('id');
        tipoMetalEditar(tmetal_id);
    });

    // Evento para eliminar
    $(document).on('click', '.btn-delete', function() {
        var tmetal_id = $(this).data('id');
        tipoMetalEliminar(tmetal_id);
    });
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
            url: "ajax.php?module=TipoMetal&controller=TipoMetal&function=data&t=" + Date.now(),
            method: "GET"
        },
        columns: [
            { data: "tmetal_id" },
            { data: "tmetal_descripcion" },
            { data: "tmetal_estado" },
            {
                data: null,
                render: function(data, type, row) {
                    return '<button class="btn btn-sm btn-primary btn-edit" data-id="' + row.tmetal_id + '">Editar</button> ' +
                           '<button class="btn btn-sm btn-danger btn-delete" data-id="' + row.tmetal_id + '">Eliminar</button>';
                }
            }
        ]
    });
};

window.tipoMetalNuevo = function () {
    $("#frmTipoMetal")[0].reset();
    $("#tmetal_id").val("");
    $("#modalTipoMetalTitle").text("Nuevo Tipo Metal");
    $("#modalTipoMetal").modal("show");
};

window.tipoMetalGuardar = function () {
    var url = ($("#tmetal_id").val() === "") ? URL_TM_POSTNEW : URL_TM_UPDATE;

    $.ajax({
        url: url,
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
        $("#tmetal_id").val(r.tmetal_id || "");
        $("#tmetal_descripcion").val(r.tmetal_descripcion || "");
        $("#tmetal_estado").val((r.tmetal_estado == 0) ? "0" : "1");
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
            url: URL_TM_DELETE,
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
