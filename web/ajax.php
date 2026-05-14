<?php
require_once __DIR__ . '/../Lib/helpers.php';

if (!isset($_GET['module']) || !isset($_GET['controller']) || !isset($_GET['function'])) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'ok' => false,
        'msg' => 'Faltan parametros (module, controller, function)'
    ]);
    exit;
}

resolve();
