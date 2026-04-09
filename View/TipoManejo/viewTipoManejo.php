<?php
$URL_TMAN_SAVE = getUrl("TipoManejo", "TipoManejo", "save", false, true);
$URL_TMAN_ONE  = getUrl("TipoManejo", "TipoManejo", "one", false, true);
$URL_TMAN_DEL  = getUrl("TipoManejo", "TipoManejo", "del", false, true);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Tipo Manejo</h3>
        <button class="btn btn-success" onclick="tipoManejoNuevo()">Nuevo</button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tblTipoManejo" class="table table-striped table-bordered w-100">
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

<div class="modal fade" id="modalTipoManejo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTipoManejoTitle">Tipo Manejo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="frmTipoManejo">
                    <input type="hidden" name="tmanejo_id_original" id="tmanejo_id_original">
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="number" class="form-control" name="tmanejo_id" id="tmanejo_id_catalogo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <input type="text" class="form-control" name="tmanejo_descripcion" id="tmanejo_descripcion_catalogo" maxlength="40" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="tmanejo_estado" id="tmanejo_estado_catalogo" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="tipoManejoGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_TMAN_SAVE = "<?= $URL_TMAN_SAVE ?>";
const URL_TMAN_ONE  = "<?= $URL_TMAN_ONE ?>";
const URL_TMAN_DEL  = "<?= $URL_TMAN_DEL ?>";
</script>
