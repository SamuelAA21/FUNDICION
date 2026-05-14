<?php

date_default_timezone_set('America/Bogota');

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

function dd($var)
{
    echo '<pre>';
    die(print_r($var, true));
}

function getUrl($modulo, $controlador, $funcion, $parametros = false, $ajax = false)
{
    $pagina = $ajax ? 'ajax' : 'index';
    $query = [
        'module' => $modulo,
        'controller' => $controlador,
        'function' => $funcion
    ];

    if ($parametros) {
        foreach ($parametros as $indice => $valor) {
            $query[$indice] = $valor;
        }
    }

    return $pagina . '.php?' . http_build_query($query);
}

function resolve($module = false, $controller = false, $function = false)
{
    if ($module === false) {
        $module = preg_replace('/[^A-Za-z0-9_]/', '', $_GET['module'] ?? '');
        $controller = preg_replace('/[^A-Za-z0-9_]/', '', $_GET['controller'] ?? '');
        $function = preg_replace('/[^A-Za-z0-9_]/', '', $_GET['function'] ?? '');
    }

    if ($module === '' || $controller === '' || $function === '') {
        echo 'Solicitud invalida';
        return;
    }

    $controllerDir = '../Controller/' . $module;
    $controllerFile = $controllerDir . '/Ctrl' . $controller . '.php';

    if (!is_dir($controllerDir)) {
        echo 'No existe carpeta';
        return;
    }

    if (!file_exists($controllerFile)) {
        echo 'No existe controller';
        return;
    }

    include_once $controllerFile;
    $nombreClase = 'Ctrl' . $controller;

    if (!class_exists($nombreClase)) {
        echo 'No existe clase';
        return;
    }

    $objClase = new $nombreClase();
    if (!method_exists($objClase, $function)) {
        echo 'No existe function';
        return;
    }

    $objClase->$function();
}

function fechaActual()
{
    $fechaActual = getdate();
    ($fechaActual['seconds'] < 10) ? $fechaActual['seconds'] = '0' . $fechaActual['seconds'] : '';
    ($fechaActual['minutes'] < 10) ? $fechaActual['minutes'] = '0' . $fechaActual['minutes'] : '';
    return $fechaActual['mday'] . ' ' . monthToString($fechaActual['mon'] - 1) . ' '
        . $fechaActual['year'] . ' a las ' . $fechaActual['hours'] . ':'
        . $fechaActual['minutes'] . ':' . $fechaActual['seconds'];
}

function fechaCastellano($fecha)
{
    $fecha = substr($fecha, 0, 10);
    $dia = date('d', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));

    $meses_ES = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $meses_EN = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $dia . ' ' . $nombreMes . ' ' . $anio;
}

function messageSweetAlert($title, $text, $type, $colorBtn, $url = null)
{
    $safeTitle = json_encode((string)$title, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $safeText = json_encode((string)$text, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $safeType = json_encode((string)$type, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $safeUrl = json_encode((string)($url ?? ''), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    echo "<script>
        swal({
            title: {$safeTitle},
            text: {$safeText},
            icon: {$safeType},
            button: 'Aceptar'
        }).then(function () {
            if ({$safeUrl}) {
                window.location.href = {$safeUrl};
            }
        });
    </script>";
}
