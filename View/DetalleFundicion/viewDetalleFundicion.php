<?php
$URL_DFUN_SAVE = getUrl("DetalleFundicion", "DetalleFundicion", "save", false, true);
$URL_DFUN_ONE  = getUrl("DetalleFundicion", "DetalleFundicion", "one", false, true);
$URL_DFUN_DEL  = getUrl("DetalleFundicion", "DetalleFundicion", "del", false, true);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Detalle Fundicion</h3>
        <button class="btn btn-success" onclick="detalleFundicionNuevo()">Nuevo</button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tblDetalleFundicion" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Registro</th>
                        <th>Materia prima</th>
                        <th>Cliente</th>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Horno</th>
                        <th>Combustible</th>
                        <th>Metal %</th>
                        <th>Doc rres</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetalleFundicion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetalleFundicionTitle">Detalle Fundicion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="frmDetalleFundicion">
                    <input type="hidden" name="dfun_id_original" id="dfun_id_original">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">ID</label>
                            <input type="number" class="form-control" name="dfun_id" id="dfun_id" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Registro fundicion</label>
                            <select class="form-select" name="rfun_id" id="rfun_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($registrosFundicion)) { ?>
                                    <option value="<?= htmlspecialchars($row['rfun_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['rfun_id'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Materia prima</label>
                            <select class="form-select" name="mat_codigo" id="df_mat_codigo" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($materiasPrimas)) { ?>
                                    <option value="<?= htmlspecialchars($row['mat_codigo'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['mat_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cliente</label>
                            <select class="form-select" name="Cli_mat" id="Cli_mat" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($clientes)) { ?>
                                    <option value="<?= htmlspecialchars($row['cli_nit'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['cli_razon_social'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number" step="any" class="form-control" name="dfun_cantidad" id="dfun_cantidad" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Producto</label>
                            <select class="form-select" name="pro_id" id="df_pro_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($productos)) { ?>
                                    <option value="<?= htmlspecialchars($row['pro_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['pro_nombre'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cant prot</label>
                            <input type="number" step="any" class="form-control" name="dfun_cantprot" id="dfun_cantprot" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Esc ID</label>
                            <input type="number" class="form-control" name="esc_id" id="esc_id" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cant esc</label>
                            <input type="number" step="any" class="form-control" name="dfun_cantesc" id="dfun_cantesc" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Horno</label>
                            <select class="form-select" name="hor_id" id="df_hor_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($hornos)) { ?>
                                    <option value="<?= htmlspecialchars($row['hor_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['hor_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Combustible</label>
                            <select class="form-select" name="com_id" id="df_com_id" required>
                                <option value="">-- Seleccione --</option>
                                <?php while ($row = mysqli_fetch_assoc($combustibles)) { ?>
                                    <option value="<?= htmlspecialchars($row['com_id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['com_descripcion'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cantidad comb</label>
                            <input type="number" step="any" class="form-control" name="dfun_cantidad_com" id="dfun_cantidad_com" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Hora inicio</label>
                            <input type="time" class="form-control" name="dfun_hinicio" id="dfun_hinicio" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Hora fin</label>
                            <input type="time" class="form-control" name="dfun_hfin" id="dfun_hfin" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Porcentaje metal</label>
                            <input type="number" class="form-control" name="dfun_per_metal" id="dfun_per_metal" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Num doc rres</label>
                            <input type="number" class="form-control" name="dfun_num_docrres" id="dfun_num_docrres" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="detalleFundicionGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_DFUN_SAVE = "<?= $URL_DFUN_SAVE ?>";
const URL_DFUN_ONE  = "<?= $URL_DFUN_ONE ?>";
const URL_DFUN_DEL  = "<?= $URL_DFUN_DEL ?>";
</script>
