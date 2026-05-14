<?php
$URL_FUNDICION_POSTNEW = getUrl("Fundicion", "Fundicion", "postNew");
?>

<div class="container mt-4 mb-5">
    <div class="fundicion-card">
        <div class="fundicion-header">
            <h3 class="m-0">Creacion Registro De Fundicion</h3>
        </div>

        <?php if (($mensaje ?? '') === 'guardado') { ?>
            <div class="alert alert-success m-3 mb-0" role="alert">
                El registro de fundicion fue guardado correctamente.
            </div>
        <?php } ?>

        <form id="frmFundicion" method="POST" action="<?= htmlspecialchars($URL_FUNDICION_POSTNEW, ENT_QUOTES, 'UTF-8') ?>">
            <div class="fundicion-body">
                <div class="fundicion-row fundicion-row-top">
                    <div class="fundicion-field">
                        <label for="fun_numero">No:</label>
                        <input type="number" id="fun_numero" name="fun_numero" class="form-control" min="1" value="<?= (int)$nextNumero ?>" readonly>
                    </div>

                    <div class="fundicion-field">
                        <label for="fun_fecha">Fecha:</label>
                        <input type="date" id="fun_fecha" name="fun_fecha" class="form-control" value="<?= htmlspecialchars(date('Y-m-d'), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <div class="fundicion-field">
                        <label for="fun_responsable">Responsable Fundicion:</label>
                        <select id="fun_responsable" name="fun_responsable" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <?php while ($row = mysqli_fetch_assoc($responsables)) { ?>
                                <?php $nombreCompleto = trim(($row['usu_nombres'] ?? '') . ' ' . ($row['usu_apellidos'] ?? '')); ?>
                                <option value="<?= htmlspecialchars($row['usu_login'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($nombreCompleto !== '' ? $nombreCompleto : $row['usu_login'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="fundicion-band">Descripcion de Materia</div>

                <div class="fundicion-grid fundicion-grid-3">
                    <div class="fundicion-field">
                        <label for="fun_materia_prima">Materia Prima</label>
                        <input type="text" id="fun_materia_prima" name="fun_materia_prima" class="form-control" list="listMateriasPrimas" autocomplete="off" required>
                        <input type="hidden" id="fun_mat_codigo" name="fun_mat_codigo">
                        <datalist id="listMateriasPrimas">
                            <?php while ($row = mysqli_fetch_assoc($materiasPrimas)) { ?>
                                <option data-id="<?= (int)$row['mat_codigo'] ?>" value="<?= htmlspecialchars($row['mat_descripcion'], ENT_QUOTES, 'UTF-8') ?>"></option>
                            <?php } ?>
                        </datalist>
                    </div>

                    <div class="fundicion-field">
                        <label for="fun_materia_cantidad">Cantidad</label>
                        <input type="number" step="0.01" id="fun_materia_cantidad" name="fun_materia_cantidad" class="form-control" min="0" required>
                    </div>

                    <div class="fundicion-field">
                        <label for="fun_cliente">Cliente</label>
                        <input type="text" id="fun_cliente" name="fun_cliente" class="form-control" list="listClientes" autocomplete="off" required>
                        <input type="hidden" id="fun_cliente_id" name="fun_cliente_id">
                        <datalist id="listClientes">
                            <?php while ($row = mysqli_fetch_assoc($clientes)) { ?>
                                <option data-id="<?= htmlspecialchars($row['cli_nit'], ENT_QUOTES, 'UTF-8') ?>" value="<?= htmlspecialchars($row['cli_razon_social'], ENT_QUOTES, 'UTF-8') ?>"></option>
                            <?php } ?>
                        </datalist>
                    </div>
                </div>

                <div class="fundicion-separator"></div>

                <div class="fundicion-grid fundicion-grid-4">
                    <div class="fundicion-field">
                        <label for="fun_producto_terminado">Producto Terminado</label>
                        <input type="text" id="fun_producto_terminado" name="fun_producto_terminado" class="form-control" list="listProductos" autocomplete="off" required>
                        <input type="hidden" id="fun_producto_id" name="fun_producto_id">
                        <datalist id="listProductos">
                            <?php while ($row = mysqli_fetch_assoc($productos)) { ?>
                                <option data-id="<?= (int)$row['pro_id'] ?>" value="<?= htmlspecialchars($row['pro_nombre'], ENT_QUOTES, 'UTF-8') ?>"></option>
                            <?php } ?>
                        </datalist>
                    </div>

                    <div class="fundicion-field">
                        <label for="fun_producto_cantidad">Cantidad</label>
                        <input type="number" step="0.01" id="fun_producto_cantidad" name="fun_producto_cantidad" class="form-control" min="0" required>
                    </div>

                    <div class="fundicion-field">
                        <label for="fun_residuo">Residuo</label>
                        <input type="text" id="fun_residuo" name="fun_residuo" class="form-control">
                    </div>

                    <div class="fundicion-field">
                        <label for="fun_residuo_cantidad">Cantidad</label>
                        <input type="number" step="0.01" id="fun_residuo_cantidad" name="fun_residuo_cantidad" class="form-control" min="0" value="0">
                    </div>
                </div>

                <div class="fundicion-grid fundicion-grid-loss">
                    <div></div>
                    <div class="fundicion-field">
                        <label for="fun_perdida_metalica">Perdida Metalica</label>
                        <input type="number" step="1" id="fun_perdida_metalica" name="fun_perdida_metalica" class="form-control" min="0" value="0">
                    </div>
                </div>

                <div class="fundicion-band fundicion-band-small">Combustible</div>

                <div class="fundicion-grid fundicion-grid-5">
                    <div class="fundicion-field">
                        <label for="fun_horno">Horno</label>
                        <select id="fun_horno" name="fun_horno" class="form-control" required>
                            <option value="">Seleccione</option>
                            <?php while ($row = mysqli_fetch_assoc($hornos)) { ?>
                                <option
                                    value="<?= (int)$row['hor_id'] ?>"
                                    data-combustible-id="<?= (int)($row['com_id'] ?? 0) ?>"
                                    data-combustible="<?= htmlspecialchars($row['com_descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($row['hor_descripcion'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="fundicion-field">
                        <label for="fun_combustible_tipo">Tipo</label>
                        <input type="text" id="fun_combustible_tipo" name="fun_combustible_tipo" class="form-control" readonly>
                    </div>

                    <div class="fundicion-field">
                        <label for="fun_combustible_cantidad">Cantidad</label>
                        <input type="number" step="0.01" id="fun_combustible_cantidad" name="fun_combustible_cantidad" class="form-control" min="0" required>
                    </div>

                    <div class="fundicion-field">
                        <label for="fun_hora_inicio">Hora Inicio</label>
                        <select id="fun_hora_inicio" name="fun_hora_inicio" class="form-control">
                            <option value="">Hora Inicio</option>
                            <?php for ($hora = 0; $hora < 24; $hora++) {
                                for ($min = 0; $min < 60; $min += 30) {
                                    $time = str_pad((string)$hora, 2, '0', STR_PAD_LEFT) . ':' . str_pad((string)$min, 2, '0', STR_PAD_LEFT); ?>
                                    <option value="<?= $time ?>"><?= $time ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="fundicion-field">
                        <label for="fun_hora_fin">Hora Fin</label>
                        <select id="fun_hora_fin" name="fun_hora_fin" class="form-control">
                            <option value="">Hora Fin</option>
                            <?php for ($hora = 0; $hora < 24; $hora++) {
                                for ($min = 0; $min < 60; $min += 30) {
                                    $time = str_pad((string)$hora, 2, '0', STR_PAD_LEFT) . ':' . str_pad((string)$min, 2, '0', STR_PAD_LEFT); ?>
                                    <option value="<?= $time ?>"><?= $time ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="fundicion-observaciones">
                    <div class="fundicion-field fundicion-observaciones-box">
                        <label for="fun_observaciones">Observaciones</label>
                        <textarea id="fun_observaciones" name="fun_observaciones" class="form-control" rows="4"></textarea>
                    </div>
                </div>

                <div class="fundicion-actions">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="index.php" class="btn btn-success">Salir</a>
                    <button type="button" id="btnLimpiarFundicion" class="btn btn-light">Limpiar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.page-main .container {
    max-width: 1160px;
}

.fundicion-card {
    background: #fff;
    border: 1px solid #ddd7ce;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.05);
}

.fundicion-header {
    border-bottom: 1px solid #e1ddd7;
    padding: 14px 18px;
    text-align: center;
}

.fundicion-header h3 {
    color: #5d544c;
    font-weight: 700;
}

.fundicion-body {
    padding: 18px;
}

.fundicion-row-top {
    display: grid;
    grid-template-columns: 190px 190px minmax(260px, 1fr);
    gap: 14px;
    align-items: end;
}

.fundicion-grid {
    display: grid;
    gap: 22px;
    margin-top: 18px;
}

.fundicion-grid-3 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
}

.fundicion-grid-4 {
    grid-template-columns: repeat(4, minmax(0, 1fr));
}

.fundicion-grid-loss {
    grid-template-columns: 1fr 190px;
    align-items: end;
}

.fundicion-grid-5 {
    grid-template-columns: 160px 1fr 1fr 180px 180px;
    align-items: end;
}

.fundicion-band {
    background: #b6b6b6;
    color: #fff;
    text-align: center;
    font-weight: 700;
    font-size: 22px;
    padding: 10px 14px;
    margin-top: 18px;
}

.fundicion-band-small {
    width: 64%;
    margin-left: auto;
    margin-right: auto;
    margin-top: 28px;
}

.fundicion-separator {
    border-top: 1px solid #e6e6e6;
    margin-top: 20px;
}

.fundicion-field label {
    display: block;
    margin-bottom: 10px;
    color: #5d544c;
    font-weight: 600;
}

.fundicion-field .form-control {
    min-height: 44px;
    border: 1px solid #b7b7b7;
    border-radius: 2px;
    box-shadow: none;
}

.fundicion-observaciones {
    margin-top: 28px;
}

.fundicion-observaciones-box {
    width: min(540px, 100%);
}

.fundicion-observaciones textarea.form-control {
    min-height: 110px;
    resize: vertical;
}

.fundicion-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.fundicion-actions .btn {
    min-width: 96px;
}

@media (max-width: 991px) {
    .fundicion-row-top,
    .fundicion-grid-3,
    .fundicion-grid-4,
    .fundicion-grid-loss,
    .fundicion-grid-5 {
        grid-template-columns: 1fr 1fr;
    }

    .fundicion-band-small {
        width: 100%;
    }
}

@media (max-width: 575px) {
    .fundicion-body {
        padding: 14px;
    }

    .fundicion-row-top,
    .fundicion-grid-3,
    .fundicion-grid-4,
    .fundicion-grid-loss,
    .fundicion-grid-5 {
        grid-template-columns: 1fr;
    }
}
</style>
