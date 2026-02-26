<?php
/* Se abre PHP */

/* Se incluye helpers para construir URLs AJAX con getUrl */
require_once __DIR__ . "/../../Lib/helpers.php";
?>

<div class="container mt-4">

  <div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="m-0">Módulo Clientes</h3>
    <button type="button" class="btn btn-success" onclick="clienteNuevo()">Nuevo Cliente</button>
  </div>

  <div class="card">
    <div class="card-body">

      <table id="tblClientes" class="table table-striped table-bordered w-100">
        <thead>
          <tr>
            <th>NIT</th>
            <th>Razón social</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Contacto</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- DataTables llena -->
        </tbody>
      </table>

    </div>
  </div>

</div>

<!-- Modal Cliente -->
<div class="modal fade" id="modalCliente" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalClienteTitle">Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form id="frmCliente">

          <div class="row g-3">

            <div class="col-md-4">
              <label class="form-label">NIT</label>
              <input type="text" class="form-control" name="cli_nit" id="cli_nit" required>
            </div>

            <div class="col-md-8">
              <label class="form-label">Razón social</label>
              <input type="text" class="form-control" name="cli_razon_social" id="cli_razon_social" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Dirección</label>
              <input type="text" class="form-control" name="cli_dir" id="cli_dir">
            </div>

            <div class="col-md-3">
              <label class="form-label">Teléfono</label>
              <input type="text" class="form-control" name="cli_tel" id="cli_tel">
            </div>

            <div class="col-md-3">
              <label class="form-label">Estado</label>
              <select class="form-select" name="cli_estado" id="cli_estado">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Correo</label>
              <input type="email" class="form-control" name="cli_correo" id="cli_correo">
            </div>

            <div class="col-md-6">
              <label class="form-label">Nombre contacto</label>
              <input type="text" class="form-control" name="cli_nombre_contacto" id="cli_nombre_contacto">
            </div>

          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="clienteGuardar()">Guardar</button>
      </div>

    </div>
  </div>
</div>

<!-- URLs generadas con helpers (para AJAX) -->
<script>
  const URL_CLIENTE_DATA = "<?php echo getUrl('Cliente','Cliente','data', false, true); ?>";
  const URL_CLIENTE_ONE  = "<?php echo getUrl('Cliente','Cliente','one', false, true); ?>";
  const URL_CLIENTE_SAVE = "<?php echo getUrl('Cliente','Cliente','save', false, true); ?>";
  const URL_CLIENTE_DEL  = "<?php echo getUrl('Cliente','Cliente','del', false, true); ?>";
</script>

<!-- JS del módulo (una sola vez) -->