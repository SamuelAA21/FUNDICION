<?php
$URL_TM_SAVE = getUrl("TipoMetal", "TipoMetal", "save", false, true);
$URL_TM_ONE  = getUrl("TipoMetal", "TipoMetal", "one", false, true);
$URL_TM_DEL  = getUrl("TipoMetal", "TipoMetal", "del", false, true);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Tipo Metal</h3>
        <button class="btn btn-success" onclick="tipoMetalNuevo()">Nuevo</button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tblTipoMetal" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTipoMetal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTipoMetalTitle">Tipo Metal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="frmTipoMetal">
                    <input type="hidden" name="tmetal_id_original" id="tmetal_id_original">
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="number" class="form-control" name="tmetal_id" id="tmetal_id" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <input type="text" class="form-control" name="tmetal_descripcion" id="tmetal_descripcion" maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="tmetal_estado" id="tmetal_estado" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="tipoMetalGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_TM_SAVE = "<?= $URL_TM_SAVE ?>";
const URL_TM_ONE  = "<?= $URL_TM_ONE ?>";
const URL_TM_DEL  = "<?= $URL_TM_DEL ?>";
</script>
