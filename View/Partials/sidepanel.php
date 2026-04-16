<div id="mySidepanel" class="sidepanel">
  <?php require_once __DIR__ . "/../../Lib/helpers.php"; ?>

  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">x</a>

  <a class="active" href="index.php">Home</a>
  <a href="#about">About</a>
  <a href="#product">Products</a>
  <a href="#contact">Contact</a>

  <a href="<?php echo getUrl('Combustible','Combustible','read'); ?>">Combustible</a>
  <a href="<?php echo getUrl('Horno','Horno','read'); ?>">Horno</a>
  <a href="<?php echo getUrl('TipoMetal','TipoMetal','read'); ?>">Tipo Metal</a>
</div>
