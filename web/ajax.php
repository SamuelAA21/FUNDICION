<?php
require_once __DIR__ . "/../Lib/helpers.php";

/*
  Este archivo sirve para peticiones AJAX.
  Debe recibir module, controller y function por GET.
  Ej:
  ajax.php?module=Cliente&controller=Cliente&function=data
*/

if (!isset($_GET["module"]) || !isset($_GET["controller"]) || !isset($_GET["function"])) {
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode([
        "ok" => false,
        "msg" => "Faltan parámetros (module, controller, function)"
    ]);
    exit;
}

resolve();