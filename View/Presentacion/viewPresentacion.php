<?php
$URL_PRES_SAVE = getUrl("Presentacion", "Presentacion", "save", false, true);
$URL_PRES_ONE  = getUrl("Presentacion", "Presentacion", "one", false, true);
$URL_PRES_DEL  = getUrl("Presentacion", "Presentacion", "del", false, true);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Presentacion</h3>
        <button class="btn btn-success" onclick="presentacionNuevo()">Nuevo</button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tblPresentacion" class="table table-striped table-bordered w-100">
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

<div class="modal fade" id="modalPresentacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPresentacionTitle">Presentacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="frmPresentacion">
                    <input type="hidden" name="pres_id_original" id="pres_id_original">
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="number" class="form-control" name="pres_id" id="pres_id_catalogo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <input type="text" class="form-control" name="pres_descripcion" id="pres_descripcion_catalogo" maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="pres_estado" id="pres_estado_catalogo" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="presentacionGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_PRES_SAVE = "<?= $URL_PRES_SAVE ?>";
const URL_PRES_ONE  = "<?= $URL_PRES_ONE ?>";
const URL_PRES_DEL  = "<?= $URL_PRES_DEL ?>";
</script>
