<?php
$URL_EM_SAVE = getUrl("EstadoMateria", "EstadoMateria", "save", false, true);
$URL_EM_ONE  = getUrl("EstadoMateria", "EstadoMateria", "one", false, true);
$URL_EM_DEL  = getUrl("EstadoMateria", "EstadoMateria", "del", false, true);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Estado Materia</h3>
        <button class="btn btn-success" onclick="estadoMateriaNuevo()">Nuevo</button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tblEstadoMateria" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEstadoMateria" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEstadoMateriaTitle">Estado Materia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="frmEstadoMateria">
                    <input type="hidden" name="ematp_id_original" id="ematp_id_original">
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="number" class="form-control" name="ematp_id" id="ematp_id_catalogo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <input type="text" class="form-control" name="ematp_descripcion" id="ematp_descripcion_catalogo" maxlength="30" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="estadoMateriaGuardar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
const URL_EM_SAVE = "<?= $URL_EM_SAVE ?>";
const URL_EM_ONE  = "<?= $URL_EM_ONE ?>";
const URL_EM_DEL  = "<?= $URL_EM_DEL ?>";
</script>
