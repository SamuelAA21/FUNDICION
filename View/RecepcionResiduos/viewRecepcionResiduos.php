<?php
$URL_RRES_SAVE = getUrl("RecepcionResiduos", "RecepcionResiduos", "save", false, true);
$URL_RRES_ONE  = getUrl("RecepcionResiduos", "RecepcionResiduos", "one", false, true);
$URL_RRES_DEL  = getUrl("RecepcionResiduos", "RecepcionResiduos", "del", false, true);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Recepcion Residuos</h3>
        <button class="btn btn-success" onclick="recepcionResiduosNuevo()">Nuevo</button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tblRecepcionResiduos" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha doc</th>
                        <th>Fecha recepcion</th>
                        <th>Cliente</th>
                        <th>Transportador</th>
                        <th>Vehiculo</th>
                        <th>Placa</th>
                        <th>Total</th>
                        <th>Manejo</th>
                        <th>Peligro</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRecepcionResiduos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRecepcionResiduosTitle">Recepcion Residuos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="frmRecepcionResiduos">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">ID</label>
                            <input type="number" class="form-control" name="rres_id" id="rres_id" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha doc</label>
                            <input type="datetime-local" class="form-control" name="rres_fecha_doc" id="rres_fecha_doc" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha recepcion</label>
                            <input type="date" class="form-control" name="rres_fecha_recepcion" id="rres_fecha_recepcion" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cliente</label>
                            <select class="form-select" name="cli_nit" id="rr_cli_nit" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($clientes)) { ?>
                                    <option value="<?= htmlspecialchars($row['cli_nit'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['cli_razon_social'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Transportador</label>
                            <input type="text" class="form-control" name="rres_transportador" id="rres_transportador" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tipo vehiculo</label>
                            <select class="form-select" name="tvehi_id" id="tvehi_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($vehiculos)) { ?>
                                    <option value="<?= htmlspecialchars($row['tvehi_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['tvehi_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Placa</label>
                            <input type="text" class="form-control" name="rres_placa" id="rres_placa" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Recomendaciones</label>
                            <textarea class="form-control" name="rres_recomendaciones" id="rres_recomendaciones" rows="3"></textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Usuario crea</label>
                            <select class="form-select" name="usu_crea" id="rr_usu_crea" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($usuariosCrea)) { ?>
                                    <option value="<?= htmlspecialchars($row['usu_cedula'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(trim($row['usu_nombres'] . ' ' . $row['usu_apellidos']), ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Total</label>
                            <input type="number" class="form-control" name="rres_total" id="rres_total" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tipo manejo</label>
                            <select class="form-select" name="tmanejo_id" id="tmanejo_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($tiposManejo)) { ?>
                                    <option value="<?= htmlspecialchars($row['tmanejo_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['tmanejo_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Peligro</label>
                            <select class="form-select" name="rres_peligro" id="rres_peligro">
                                <option value="">-- Seleccione --</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Codigo QR</label>
                            <input type="text" class="form-control" name="rres_codigo_qr" id="rres_codigo_qr">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="rres_estado" id="rres_estado" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                <option value="Anulado">Anulado</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Usuario anula</label>
                            <select class="form-select" name="usu_anula" id="rr_usu_anula">
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($usuariosAnula)) { ?>
                                    <option value="<?= htmlspecialchars($row['usu_cedula'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(trim($row['usu_nombres'] . ' ' . $row['usu_apellidos']), ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha anula</label>
                            <input type="datetime-local" class="form-control" name="fecha_anula" id="fecha_anula">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Razon anula</label>
                            <textarea class="form-control" name="razon_anula" id="razon_anula" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="recepcionResiduosGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_RRES_SAVE = "<?= $URL_RRES_SAVE ?>";
const URL_RRES_ONE  = "<?= $URL_RRES_ONE ?>";
const URL_RRES_DEL  = "<?= $URL_RRES_DEL ?>";
</script>
