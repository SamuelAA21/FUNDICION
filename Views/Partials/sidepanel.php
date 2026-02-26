<div id="mySidepanel" class="sidepanel">
  <?php require_once __DIR__ . "/../../Lib/helpers.php"; ?>
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  <a class="active" href="index.php">Home</a>
  <a href="#about">About</a>
  <a href="#product">Products</a>
  <a href="#contact">Contact</a>
  <a href="<?php echo getUrl('User','User','crear_usuario'); ?>">Crear usuario</a>
</div>
