<?php
$URL_MP_SAVE = getUrl("MateriaPrima", "MateriaPrima", "save", false, true);
$URL_MP_ONE  = getUrl("MateriaPrima", "MateriaPrima", "one", false, true);
$URL_MP_DEL  = getUrl("MateriaPrima", "MateriaPrima", "del", false, true);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Materia Prima</h3>
        <button class="btn btn-success" onclick="materiaPrimaNuevo()">Nuevo</button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tblMateriaPrima" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Peligrosidad</th>
                        <th>Tipo metal</th>
                        <th>Estado materia</th>
                        <th>Presentacion</th>
                        <th>Corr</th>
                        <th>Bodega</th>
                        <th>Tipo peligro</th>
                        <th>Producto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMateriaPrima" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMateriaPrimaTitle">Materia Prima</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="frmMateriaPrima">
                    <input type="hidden" name="mat_codigo_original" id="mat_codigo_original">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Codigo</label>
                            <input type="number" class="form-control" name="mat_codigo" id="mat_codigo" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Descripcion</label>
                            <input type="text" class="form-control" name="mat_descripcion" id="mat_descripcion">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Peligrosidad</label>
                            <select class="form-select" name="mat_peligrosidad" id="mat_peligrosidad" required>
                                <option value="">-- Seleccione --</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tipo metal</label>
                            <select class="form-select" name="tmetal_id" id="tmetal_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($tiposMetal)) { ?>
                                    <option value="<?= htmlspecialchars($row['tmetal_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['tmetal_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado materia</label>
                            <select class="form-select" name="ematp_id" id="ematp_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($estadosMateria)) { ?>
                                    <option value="<?= htmlspecialchars($row['ematp_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['ematp_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Presentacion</label>
                            <select class="form-select" name="pres_id" id="pres_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($presentaciones)) { ?>
                                    <option value="<?= htmlspecialchars($row['pres_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['pres_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Corr ID</label>
                            <input type="number" class="form-control" name="corr_id" id="corr_id" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Bodega</label>
                            <select class="form-select" name="bod_id" id="bod_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($bodegas)) { ?>
                                    <option value="<?= htmlspecialchars($row['bod_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['bod_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tipo peligro</label>
                            <select class="form-select" name="tpel_id" id="tpel_id">
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($tiposPeligro)) { ?>
                                    <option value="<?= htmlspecialchars($row['tpel_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['tpel_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Producto terminado</label>
                            <select class="form-select" name="pro_id" id="pro_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($productos)) { ?>
                                    <option value="<?= htmlspecialchars($row['pro_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['pro_nombre'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="mat_estado" id="mat_estado" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="materiaPrimaGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_MP_SAVE = "<?= $URL_MP_SAVE ?>";
const URL_MP_ONE  = "<?= $URL_MP_ONE ?>";
const URL_MP_DEL  = "<?= $URL_MP_DEL ?>";
</script>
