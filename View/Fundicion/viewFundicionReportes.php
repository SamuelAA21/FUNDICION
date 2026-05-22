<?php
$URL_FUNDICION_DATA = getUrl("Fundicion", "Fundicion", "data", false, true);
?>

<div class="container mt-4 mb-5">
    <div class="fundicion-card">
        <div class="fundicion-header">
            <h3 class="m-0">Reportes de Fundicion</h3>
        </div>
        <div class="fundicion-body">
            <div class="d-flex flex-wrap gap-2 mb-3" id="fundicionReporteActions">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnFundicionCopiar">Copiar</button>
                <button type="button" class="btn btn-success btn-sm" id="btnFundicionExcel">Excel</button>
                <button type="button" class="btn btn-danger btn-sm" id="btnFundicionPdf">PDF</button>
                <button type="button" class="btn btn-info btn-sm" id="btnFundicionImprimir">Imprimir</button>
            </div>

            <div class="fundicion-search-bar">
                <div class="fundicion-search-field">
                    <label for="txtBuscarFundicion">Buscar en reportes</label>
                    <input type="text" id="txtBuscarFundicion" class="form-control" placeholder="Ej: 2, chatarra, cliente...">
                </div>
                <div class="fundicion-search-actions">
                    <button type="button" class="btn btn-primary" id="btnBuscarFundicion">Buscar</button>
                    <button type="button" class="btn btn-light" id="btnLimpiarBusquedaFundicion">Limpiar</button>
                </div>
            </div>

            <div id="graficaFundicionProducto" style="width:100%; height:400px; margin-bottom:20px;"></div>

            <div class="table-responsive">
                <table id="tblFundicionReporte" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Fecha</th>
                            <th>Responsable</th>
                            <th>Materia Prima</th>
                            <th>Cant. Materia</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Cant. Producto</th>
                            <th>Residuo</th>
                            <th>Horno</th>
                            <th>Combustible</th>
                            <th>Cant. Combustible</th>
                            <th>Horario</th>
                            <th>Perdida Metalica</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
const URL_FUNDICION_DATA = "<?= $URL_FUNDICION_DATA ?>";
</script>

<script src="https://code.highcharts.com/highcharts.js"></script>

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

.dt-buttons {
    display: none;
}

.dataTables_filter {
    display: none;
}

.fundicion-search-bar {
    display: grid;
    grid-template-columns: minmax(280px, 420px) auto;
    gap: 14px;
    align-items: end;
    margin-bottom: 18px;
}

.fundicion-search-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

@media (max-width: 991px) {
    .fundicion-search-bar {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 575px) {
    .fundicion-body {
        padding: 14px;
    }
}
</style>
