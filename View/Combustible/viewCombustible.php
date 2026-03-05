<?php
// URLs Ajax siguiendo su helper getUrl(...)
$URL_COMBUSTIBLE_SAVE = getUrl("Combustible","Combustible","save",false,true);
$URL_COMBUSTIBLE_ONE  = getUrl("Combustible","Combustible","one",false,true);
$URL_COMBUSTIBLE_DEL  = getUrl("Combustible","Combustible","del",false,true);
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
                <th>Descripción</th>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form id="frmCombustible">

            <input type="hidden" name="comb_id" id="comb_id">

            <div class="mb-3">
                <label class="form-label">Descripción</label>
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="combustibleGuardar()">Guardar</button>
      </div>

    </div>
  </div>
</div>

<script>
const URL_COMBUSTIBLE_SAVE = "<?= $URL_COMBUSTIBLE_SAVE ?>";
const URL_COMBUSTIBLE_ONE  = "<?= $URL_COMBUSTIBLE_ONE ?>";
const URL_COMBUSTIBLE_DEL  = "<?= $URL_COMBUSTIBLE_DEL ?>";
</script>