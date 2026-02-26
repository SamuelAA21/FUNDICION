<?php
require_once __DIR__ . "/../../Lib/Config/conexionSqli.php";

class CtrlUser {

    public function home() {
    require_once __DIR__ . "/../../Views/Home/home.php";
  }
  public function login() {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $error = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

      $usuario = trim($_POST["usuario"] ?? "");
      $clave   = trim($_POST["clave"] ?? "");

      $con = new Connection();
      $link = $con->getConnect();

      $usuarioEsc = mysqli_real_escape_string($link, $usuario);

      $sql = "
        SELECT usu_cedula, usu_login, usu_nombres, usu_pass
        FROM usuario
        WHERE usu_login = '$usuarioEsc' OR usu_correo = '$usuarioEsc'
        LIMIT 1
      ";

      $res = $con->execute($sql);
      $user = mysqli_fetch_assoc($res);

      if ($user && $user["usu_pass"] === $clave && $user["usu_estado"] == "1") {
        $_SESSION["usuario"] = [
          "cedula" => $user["usu_cedula"],
          "login"  => $user["usu_login"],
          "nombre" => $user["usu_nombres"]
        ];

        $con->closeConect();
        header("Location: index.php?accion=listado");
        exit;
      } else {
        $error = "Usuario o contraseña incorrectos";
      }

      $con->closeConect();
    }

    require_once __DIR__ . "/../../Views/User/login.php";
  }

  public function listado() {
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION["usuario"])) {
      header("Location: index.php?accion=login");
      exit;
    }

    echo "Bienvenido " . $_SESSION["usuario"]["nombre"];
    echo " | <a href='index.php?accion=logout'>Salir</a>";
  }

  public function logout() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    session_destroy();
    header("Location: index.php?accion=login");
    exit;
  }

  public function crear_usuario() {
  $error = "";
  $msg = "";
  include_once __DIR__ . "/../../Views/User/CreateUser.php";
}

public function guardar_usuario() {
  require_once __DIR__ . "/../../Lib/Config/conexionSqli.php";

  $con  = new Connection();
  $link = $con->getConnect();

  $error = "";
  $msg = "";

  $cedula    = trim($_POST["usu_cedula"] ?? "");
  $login     = trim($_POST["usu_login"] ?? "");
  $nombres   = trim($_POST["usu_nombres"] ?? "");
  $apellidos = trim($_POST["usu_apellidos"] ?? "");
  $correo    = trim($_POST["usu_correo"] ?? "");
  $pass      = trim($_POST["usu_pass"] ?? "");

  // obligatorios en tu tabla (según estructura típica)
  $per_codigo  = (int)($_POST["per_codigo"] ?? 1);
  $car_codigo  = (int)($_POST["car_codigo"] ?? 1);
  $usu_estado  = "1";
  $usu_tel     = trim($_POST["usu_tel"] ?? "");
  $usu_dir     = trim($_POST["usu_dir"] ?? "");
  $usu_usucrea = "system";

  if ($cedula==="" || $login==="" || $nombres==="" || $apellidos==="" || $correo==="" || $pass==="") {
    $error = "Completa los campos obligatorios.";
    $con->closeConect();
    include_once __DIR__ . "/../../Views/User/crear_usuario.php";
    return;
  }

  // escapar
  $cedulaEsc  = mysqli_real_escape_string($link, $cedula);
  $loginEsc   = mysqli_real_escape_string($link, $login);
  $nomEsc     = mysqli_real_escape_string($link, $nombres);
  $apeEsc     = mysqli_real_escape_string($link, $apellidos);
  $correoEsc  = mysqli_real_escape_string($link, $correo);
  $passEsc    = mysqli_real_escape_string($link, $pass);
  $telEsc     = mysqli_real_escape_string($link, $usu_tel);
  $dirEsc     = mysqli_real_escape_string($link, $usu_dir);
  $usucreaEsc = mysqli_real_escape_string($link, $usu_usucrea);

  // validar duplicados
  $check = $con->execute("
    SELECT 1 FROM usuario
    WHERE usu_cedula='$cedulaEsc' OR usu_login='$loginEsc' OR usu_correo='$correoEsc'
    LIMIT 1
  ");
  if (mysqli_fetch_assoc($check)) {
    $error = "Ya existe un usuario con esa cédula, login o correo.";
    $con->closeConect();
    include_once __DIR__ . "/../../Views/User/CreateUser.php";
    return;
  }

  $sql = "
    INSERT INTO usuario
    (usu_cedula, usu_login, usu_nombres, usu_apellidos, usu_correo,
     per_codigo, usu_fecha_crea, usu_usucrea, usu_estado, usu_tel, usu_dir, car_codigo, usu_pass)
    VALUES
    ('$cedulaEsc', '$loginEsc', '$nomEsc', '$apeEsc', '$correoEsc',
     $per_codigo, CURDATE(), '$usucreaEsc', '$usu_estado', '$telEsc', '$dirEsc', $car_codigo, '$passEsc')
  ";

  $con->execute($sql);
  $con->closeConect();

  $msg = "Usuario creado correctamente.";
  include_once __DIR__ . "/../../Views/User/CreateUser.php";
}

}