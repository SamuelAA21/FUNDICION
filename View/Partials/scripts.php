<!-- 1) jQuery (uno solo) -->
<script src="js/jquery-3.4.1.min.js"></script>

<!-- 2) Plugins que dependen de jQuery -->
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- 3) DataTables -->
<script src="js/datatables.min.js"></script>

<!-- 4) SweetAlert -->
<script src="js/sweet_alert.min.js"></script>

<!-- 5) Bootstrap (BS4) -->
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- Extra -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>

<!-- 6) Scripts del template -->
<script src="js/custom.js"></script>

<?php if (isset($_GET['module'])) {
    if ($_GET['module'] === 'Cliente') {
        echo '<script src="js/cliente.js"></script>';
    }
    if ($_GET['module'] === 'Combustible') {
        echo '<script src="js/combustible.js"></script>';
    }
    if ($_GET['module'] === 'Horno') {
        echo '<script src="js/horno.js"></script>';
    }
    if ($_GET['module'] === 'MateriaPrima') {
        echo '<script src="js/materia_prima.js"></script>';
    }
    if ($_GET['module'] === 'TipoMetal') {
        echo '<script src="js/tipo_metal.js"></script>';
    }
    if ($_GET['module'] === 'EstadoMateria') {
        echo '<script src="js/estado_materia.js"></script>';
    }
    if ($_GET['module'] === 'Presentacion') {
        echo '<script src="js/presentacion.js"></script>';
    }
    if ($_GET['module'] === 'Bodega') {
        echo '<script src="js/bodega.js"></script>';
    }
    if ($_GET['module'] === 'TipoPeligro') {
        echo '<script src="js/tipo_peligro.js"></script>';
    }
    if ($_GET['module'] === 'TipoVehiculo') {
        echo '<script src="js/tipo_vehiculo.js"></script>';
    }
    if ($_GET['module'] === 'TipoManejo') {
        echo '<script src="js/tipo_manejo.js"></script>';
    }
    if ($_GET['module'] === 'ProductoTerminado') {
        echo '<script src="js/producto_terminado.js"></script>';
    }
    if ($_GET['module'] === 'RecepcionResiduos') {
        echo '<script src="js/recepcion_residuos.js"></script>';
    }
    if ($_GET['module'] === 'DetalleFundicion') {
        echo '<script src="js/detalle_fundicion.js"></script>';
    }
    if ($_GET['module'] === 'Fundicion') {
        echo '<script src="js/fundicion.js"></script>';
    }
} ?>
