<?php
$URL_HORNO_POSTNEW = getUrl("Horno","Horno","postNew",false,true);
$URL_HORNO_UPDATE  = getUrl("Horno","Horno","update",false,true);
$URL_HORNO_ONE     = getUrl("Horno","Horno","one",false,true);
$URL_HORNO_DELETE  = getUrl("Horno","Horno","delete",false,true);
?>
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Horno</h3>
        <button class="btn btn-success" onclick="hornoNuevo()">Nuevo</button>
    </div>

    <table id="tblHorno" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Combustible</th>
                <th>Estado</th>
                <th style="width: 160px;">Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

</div>

<div class="modal fade" id="modalHorno" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalHornoTitle">Nuevo Horno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="frmHorno">

            <input type="hidden" name="hor_id" id="hor_id">

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <input type="text" class="form-control" name="hor_descripcion" id="hor_descripcion" maxlength="50" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Combustible</label>
                <select class="form-select" name="com_id" id="com_id" required>
                    <option value="">-- Seleccione --</option>
                    <?php foreach ($combustibles as $combustible) { ?>
                        <option value="<?= htmlspecialchars((string)$combustible['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($combustible['descripcion'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select class="form-select" name="hor_estado" id="hor_estado">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>

        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="hornoGuardar()">Guardar</button>
      </div>

    </div>
  </div>
</div>

<script>
const URL_HORNO_POSTNEW = "<?= $URL_HORNO_POSTNEW ?>";
const URL_HORNO_UPDATE  = "<?= $URL_HORNO_UPDATE ?>";
const URL_HORNO_ONE     = "<?= $URL_HORNO_ONE ?>";
const URL_HORNO_DELETE  = "<?= $URL_HORNO_DELETE ?>";
</script>
