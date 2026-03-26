var tablaHorno = null;

$(document).ready(function () {
    listHorno();
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
            url: "ajax.php?module=Horno&controller=Horno&function=data",
            method: "GET"
        },
        deferRender: true,
        columns: [
            { data: "hor_id" },
            { data: "hor_descripcion" },
            { data: "com_descripcion" },
            { data: "hor_estado" },
            { data: "acciones" }
        ]
    });
};

window.hornoNuevo = function () {
    $("#frmHorno")[0].reset();
    $("#hor_id").val("");

    var firstComb = $("#com_id option:not([value=''])").first().val();
    if (firstComb) {
        $("#com_id").val(firstComb).trigger("change");
    }

    $("#modalHornoTitle").text("Nuevo Horno");
    $("#modalHorno").modal("show");
}

window.hornoGuardar = function () {
    let comId = $("#com_id").val();
    console.log("[Horno] com_id before validation:", comId);
    console.log("[Horno] comb options:", $("#com_id").find("option").map(function(){ return this.value;}).get());

    if (!comId || parseInt(comId) <= 0) {
        const fallback = $("#com_id option:not([value=''])").first().val();
        if (fallback) {
            comId = fallback;
            $("#com_id").val(comId).trigger("change");
            console.log("[Horno] com_id fallback to:", comId);
        }
    }

    if (!comId || parseInt(comId) <= 0) {
        swal("Error", "Seleccione un combustible válido", "error");
        return;
    }

    $.ajax({
        url: URL_HORNO_SAVE,
        type: "POST",
        data: $("#frmHorno").serialize(),
        dataType: "json"
    }).done(function (r) {
        if (!r || typeof r.ok === 'undefined') {
            swal("Error", "Respuesta inválida del servidor", "error");
            return;
        }

        if (r.ok) {
            $("#modalHorno").modal("hide");
            tablaHorno.ajax.reload(null, false);
            swal("Operación exitosa", r.msg || "Horno guardado", "success");
        } else {
            swal("Error", r.msg || "No se pudo guardar el horno", "error");
        }

    }).fail(function () {
        swal("Error", "Fallo la petición al servidor", "error");
    });
}

window.hornoEditar = function(hor_id) {
    var id = parseInt(hor_id, 10);
    if (isNaN(id) || id <= 0) {
        swal("Error", "ID inválido", "error");
        return;
    }

    $.ajax({
        url: URL_HORNO_ONE,
        type: "POST",
        data: { hor_id: id },
        dataType: "json"
    }).done(function (r) {

            $("#hor_id").val(r.hor_id || "");
        $("#hor_descripcion").val(r.hor_descripcion || "");

        let selectedComb = (r.com_id || "");
        if (selectedComb === "" || $("#com_id option[value='" + selectedComb + "']").length === 0) {
            selectedComb = $("#com_id option:not([value=''])").first().val() || "";
        }
        $("#com_id").val(selectedComb).trigger("change");

        $("#hor_estado").val((r.hor_estado == 0) ? "0" : "1");

        $("#modalHornoTitle").text("Editar Horno");
        $("#modalHorno").modal("show");

    }).fail(function () {
        swal("Error", "No se pudo cargar el horno", "error");
    });
}

window.hornoEliminar = function(hor_id) {
    var id = parseInt(hor_id, 10);
    if (isNaN(id) || id <= 0) {
        swal("Error", "ID inválido", "error");
        return;
    }

    swal({
        title: "¿Eliminar horno?",
        text: "ID: " + id,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((ok) => {

        if (!ok) return;

        $.ajax({
            url: URL_HORNO_DEL,
            type: "POST",
            data: { hor_id: id },
            dataType: "json"
        }).done(function (r) {
            if (!r || typeof r.ok === 'undefined') {
                swal("Error", "Respuesta inválida del servidor", "error");
                return;
            }

            if (r.ok) {
                tablaHorno.ajax.reload(null, false);
                swal("Eliminado", r.msg || "Horno eliminado", "success");
            } else {
                swal("Error", r.msg || "No se pudo eliminar", "error");
            }

        }).fail(function () {
            swal("Error", "No se pudo eliminar", "error");
        });

    });
}