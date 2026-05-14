<?php
$URL_COMBUSTIBLE_POSTNEW = getUrl('Combustible', 'Combustible', 'postNew', false, true);
$URL_COMBUSTIBLE_UPDATE = getUrl('Combustible', 'Combustible', 'update', false, true);
$URL_COMBUSTIBLE_ONE = getUrl('Combustible', 'Combustible', 'one', false, true);
$URL_COMBUSTIBLE_DELETE = getUrl('Combustible', 'Combustible', 'delete', false, true);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Combustible</h3>
        <button class="btn btn-success" onclick="combustibleNuevo()">Nuevo</button>
    </div>

    <table id="tblCombustible" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th style="width: 160px;">Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="modal fade" id="modalCombustible" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCombustibleTitle">Nuevo Combustible</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="frmCombustible">
                    <input type="hidden" name="comb_id" id="comb_id">

                    <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <input type="text" class="form-control" name="comb_descripcion" id="comb_descripcion" maxlength="30" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="comb_estado" id="comb_estado">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="combustibleGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_COMBUSTIBLE_POSTNEW = "<?= htmlspecialchars($URL_COMBUSTIBLE_POSTNEW, ENT_QUOTES, 'UTF-8') ?>";
const URL_COMBUSTIBLE_UPDATE  = "<?= htmlspecialchars($URL_COMBUSTIBLE_UPDATE, ENT_QUOTES, 'UTF-8') ?>";
const URL_COMBUSTIBLE_ONE     = "<?= htmlspecialchars($URL_COMBUSTIBLE_ONE, ENT_QUOTES, 'UTF-8') ?>";
const URL_COMBUSTIBLE_DELETE  = "<?= htmlspecialchars($URL_COMBUSTIBLE_DELETE, ENT_QUOTES, 'UTF-8') ?>";
</script>
