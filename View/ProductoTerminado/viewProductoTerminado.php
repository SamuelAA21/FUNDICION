<?php
$URL_PT_SAVE = getUrl("ProductoTerminado", "ProductoTerminado", "save", false, true);
$URL_PT_ONE  = getUrl("ProductoTerminado", "ProductoTerminado", "one", false, true);
$URL_PT_DEL  = getUrl("ProductoTerminado", "ProductoTerminado", "del", false, true);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Producto Terminado</h3>
        <button class="btn btn-success" onclick="productoTerminadoNuevo()">Nuevo</button>
    </div>

    <table id="tblProductoTerminado" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo metal</th>
                <th>Presentacion</th>
                <th>Bodega</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="modal fade" id="modalProductoTerminado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProductoTerminadoTitle">Producto Terminado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="frmProductoTerminado">
                    <input type="hidden" name="pro_id_original" id="pro_id_original">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">ID</label>
                            <input type="number" class="form-control" name="pro_id" id="pro_id" required>
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="pro_nombre" id="pro_nombre" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tipo metal</label>
                            <select class="form-select" name="tmetal_id" id="pt_tmetal_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($tiposMetal)) { ?>
                                    <option value="<?= htmlspecialchars($row['tmetal_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['tmetal_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Presentacion</label>
                            <select class="form-select" name="pres_id" id="pt_pres_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($presentaciones)) { ?>
                                    <option value="<?= htmlspecialchars($row['pres_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['pres_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Bodega</label>
                            <select class="form-select" name="bod_id" id="pt_bod_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($bodegas)) { ?>
                                    <option value="<?= htmlspecialchars($row['bod_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['bod_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="pro_estado" id="pro_estado" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="productoTerminadoGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_PT_SAVE = "<?= $URL_PT_SAVE ?>";
const URL_PT_ONE  = "<?= $URL_PT_ONE ?>";
const URL_PT_DEL  = "<?= $URL_PT_DEL ?>";
</script>
