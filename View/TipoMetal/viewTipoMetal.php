<?php
$URL_TM_POSTNEW = getUrl('TipoMetal', 'TipoMetal', 'postNew', false, true);
$URL_TM_UPDATE = getUrl('TipoMetal', 'TipoMetal', 'update', false, true);
$URL_TM_ONE = getUrl('TipoMetal', 'TipoMetal', 'one', false, true);
$URL_TM_DELETE = getUrl('TipoMetal', 'TipoMetal', 'delete', false, true);
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmTipoMetal">
                    <input type="hidden" name="tmetal_id" id="tmetal_id">
                    <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <input type="text" class="form-control" name="tmetal_descripcion" id="tmetal_descripcion" maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="tmetal_estado" id="tmetal_estado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="tipoMetalGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_TM_POSTNEW = "<?= htmlspecialchars($URL_TM_POSTNEW, ENT_QUOTES, 'UTF-8') ?>";
const URL_TM_UPDATE  = "<?= htmlspecialchars($URL_TM_UPDATE, ENT_QUOTES, 'UTF-8') ?>";
const URL_TM_ONE     = "<?= htmlspecialchars($URL_TM_ONE, ENT_QUOTES, 'UTF-8') ?>";
const URL_TM_DELETE  = "<?= htmlspecialchars($URL_TM_DELETE, ENT_QUOTES, 'UTF-8') ?>";
</script>
