<!DOCTYPE html>
<html lang="en">
<?php include_once(__DIR__ . "/../Partials/head.php"); ?>
<body class="main-layout">

<?php include_once(__DIR__ . "/../Partials/loader.php"); ?>
<?php include_once(__DIR__ . "/../Partials/sidepanel.php"); ?>
<?php include_once(__DIR__ . "/../Partials/header.php"); ?>

<div class="contact">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="bg_yeloow">
          <div class="titlepage text_align_center">
            <h2>Crear usuario</h2>
          </div>

          <div class="row">
            <div class="col-md-10 offset-md-1">

              <?php if (!empty($error)): ?>
                <div style="padding:10px; margin:10px; background:#ffd6d6;">
                  <?php echo $error; ?>
                </div>
              <?php endif; ?>

              <?php if (!empty($msg)): ?>
                <div style="padding:10px; margin:10px; background:#d6ffe0;">
                  <?php echo $msg; ?>
                </div>
              <?php endif; ?>

              <form class="main_form" method="post"
                action="<?php echo getUrl('User','User','guardar_usuario'); ?>">
                <div class="row">

                  <div class="col-md-12">
                    <input class="contactus" placeholder="Cédula" type="text" name="usu_cedula" required>
                  </div>

                  <div class="col-md-12">
                    <input class="contactus" placeholder="Login" type="text" name="usu_login" required>
                  </div>

                  <div class="col-md-12">
                    <input class="contactus" placeholder="Nombres" type="text" name="usu_nombres" required>
                  </div>

                  <div class="col-md-12">
                    <input class="contactus" placeholder="Apellidos" type="text" name="usu_apellidos" required>
                  </div>

                  <div class="col-md-12">
                    <input class="contactus" placeholder="Correo" type="email" name="usu_correo" required>
                  </div>

                  <div class="col-md-12">
                    <input class="contactus" placeholder="Teléfono" type="text" name="usu_tel">
                  </div>

                  <div class="col-md-12">
                    <input class="contactus" placeholder="Dirección" type="text" name="usu_dir">
                  </div>

                  <div class="col-md-6">
                    <input class="contactus" placeholder="per_codigo" type="number" name="per_codigo" value="1">
                  </div>

                  <div class="col-md-6">
                    <input class="contactus" placeholder="car_codigo" type="number" name="car_codigo" value="1">
                  </div>

                  <div class="col-md-12">
                    <input class="contactus" placeholder="Contraseña" type="password" name="usu_pass" required>
                  </div>

                  <div class="col-md-12">
                    <button class="send_btn" type="submit">Crear</button>
                  </div>

                </div>
              </form>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once(__DIR__ . "/../Partials/scripts.php"); ?>
</body>
</html>