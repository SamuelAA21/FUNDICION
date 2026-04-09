<?php
$URL_TPEL_SAVE = getUrl("TipoPeligro", "TipoPeligro", "save", false, true);
$URL_TPEL_ONE  = getUrl("TipoPeligro", "TipoPeligro", "one", false, true);
$URL_TPEL_DEL  = getUrl("TipoPeligro", "TipoPeligro", "del", false, true);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Tipo Peligro</h3>
        <button class="btn btn-success" onclick="tipoPeligroNuevo()">Nuevo</button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tblTipoPeligro" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripcion</th>
                        <th>Especifica</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTipoPeligro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTipoPeligroTitle">Tipo Peligro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="frmTipoPeligro">
                    <input type="hidden" name="tpel_id_original" id="tpel_id_original">
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="number" class="form-control" name="tpel_id" id="tpel_id_catalogo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <input type="text" class="form-control" name="tpel_descripcion" id="tpel_descripcion" maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Especifica</label>
                        <input type="text" class="form-control" name="tpel_especifica" id="tpel_especifica" maxlength="60" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="tpel_estado" id="tpel_estado" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="tipoPeligroGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_TPEL_SAVE = "<?= $URL_TPEL_SAVE ?>";
const URL_TPEL_ONE  = "<?= $URL_TPEL_ONE ?>";
const URL_TPEL_DEL  = "<?= $URL_TPEL_DEL ?>";
</script>
