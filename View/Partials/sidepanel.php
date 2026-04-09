<div id="mySidepanel" class="sidepanel">
  <?php require_once __DIR__ . "/../../Lib/helpers.php"; ?>

  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">x</a>

  <a class="active" href="<?php echo getUrl('User','User','home'); ?>">Home</a>
  <a href="#about">About</a>
  <a href="#product">Products</a>
  <a href="#contact">Contact</a>

  <a href="<?php echo getUrl('User','User','crear_usuario'); ?>">Crear usuario</a>
  <a href="<?php echo getUrl('Cliente','Cliente','read'); ?>">Clientes</a>
  <a href="<?php echo getUrl('Combustible','Combustible','read'); ?>">Combustible</a>
  <a href="<?php echo getUrl('Horno','Horno','read'); ?>">Horno</a>
  <a href="<?php echo getUrl('TipoMetal','TipoMetal','read'); ?>">Tipo Metal</a>
  <a href="<?php echo getUrl('EstadoMateria','EstadoMateria','read'); ?>">Estado Materia</a>
  <a href="<?php echo getUrl('Presentacion','Presentacion','read'); ?>">Presentacion</a>
  <a href="<?php echo getUrl('Bodega','Bodega','read'); ?>">Bodega</a>
  <a href="<?php echo getUrl('TipoPeligro','TipoPeligro','read'); ?>">Tipo Peligro</a>
  <a href="<?php echo getUrl('TipoVehiculo','TipoVehiculo','read'); ?>">Tipo Vehiculo</a>
  <a href="<?php echo getUrl('TipoManejo','TipoManejo','read'); ?>">Tipo Manejo</a>
  <a href="<?php echo getUrl('MateriaPrima','MateriaPrima','read'); ?>">Materia Prima</a>
  <a href="<?php echo getUrl('ProductoTerminado','ProductoTerminado','read'); ?>">Producto Terminado</a>
  <a href="<?php echo getUrl('RecepcionResiduos','RecepcionResiduos','read'); ?>">Recepcion Residuos</a>
  <a href="<?php echo getUrl('DetalleFundicion','DetalleFundicion','read'); ?>">Detalle Fundicion</a>
</div>
