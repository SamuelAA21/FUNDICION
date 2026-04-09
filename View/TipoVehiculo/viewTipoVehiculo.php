<?php
$URL_TV_SAVE = getUrl("TipoVehiculo", "TipoVehiculo", "save", false, true);
$URL_TV_ONE  = getUrl("TipoVehiculo", "TipoVehiculo", "one", false, true);
$URL_TV_DEL  = getUrl("TipoVehiculo", "TipoVehiculo", "del", false, true);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Tipo Vehiculo</h3>
        <button class="btn btn-success" onclick="tipoVehiculoNuevo()">Nuevo</button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tblTipoVehiculo" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTipoVehiculo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTipoVehiculoTitle">Tipo Vehiculo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="frmTipoVehiculo">
                    <input type="hidden" name="tvehi_id_original" id="tvehi_id_original">
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="number" class="form-control" name="tvehi_id" id="tvehi_id_catalogo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <input type="text" class="form-control" name="tvehi_descripcion" id="tvehi_descripcion_catalogo" maxlength="30" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="tipoVehiculoGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_TV_SAVE = "<?= $URL_TV_SAVE ?>";
const URL_TV_ONE  = "<?= $URL_TV_ONE ?>";
const URL_TV_DEL  = "<?= $URL_TV_DEL ?>";
</script>
