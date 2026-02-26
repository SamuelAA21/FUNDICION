<div id="mySidepanel" class="sidepanel">
  <?php require_once __DIR__ . "/../../Lib/helpers.php"; ?>

  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>

  <!-- Home: si tu home se sirve desde un módulo, usa getUrl -->
  <a class="active" href="<?php echo getUrl('User','User','home'); ?>">Home</a>

  <!-- Secciones del template (anclas internas) -->
  <a href="#about">About</a>
  <a href="#product">Products</a>
  <a href="#contact">Contact</a>

  <!-- Módulos del sistema (con helpers) -->
  <a href="<?php echo getUrl('User','User','crear_usuario'); ?>">Crear usuario</a>
  <a href="<?php echo getUrl('Cliente','Cliente','read'); ?>">Clientes</a>

  <!-- Si luego creas más módulos, los agregas igual -->
  <!--
  <a href="<?php echo getUrl('Empleado','Empleado','read'); ?>">Empleados</a>
  <a href="<?php echo getUrl('MateriaPrima','MateriaPrima','read'); ?>">Materia Prima</a>
  <a href="<?php echo getUrl('ProductoTerminado','ProductoTerminado','read'); ?>">Producto Terminado</a>
  -->
</div>