<?php
$URL_BOD_SAVE = getUrl("Bodega", "Bodega", "save", false, true);
$URL_BOD_ONE  = getUrl("Bodega", "Bodega", "one", false, true);
$URL_BOD_DEL  = getUrl("Bodega", "Bodega", "del", false, true);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Bodega</h3>
        <button class="btn btn-success" onclick="bodegaNuevo()">Nuevo</button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tblBodega" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripcion</th>
                        <th>Capacidad</th>
                        <th>Area</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBodega" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBodegaTitle">Bodega</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="frmBodega">
                    <input type="hidden" name="bod_id_original" id="bod_id_original">
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="number" class="form-control" name="bod_id" id="bod_id_catalogo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <input type="text" class="form-control" name="bod_descripcion" id="bod_descripcion" maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Capacidad</label>
                        <input type="text" class="form-control" name="bod_capacidad" id="bod_capacidad" maxlength="20" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Area</label>
                        <input type="text" class="form-control" name="bod_area" id="bod_area" maxlength="20" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="bod_estado" id="bod_estado" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="bodegaGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_BOD_SAVE = "<?= $URL_BOD_SAVE ?>";
const URL_BOD_ONE  = "<?= $URL_BOD_ONE ?>";
const URL_BOD_DEL  = "<?= $URL_BOD_DEL ?>";
</script>
