<?php

if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}
if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}
if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '');
}
if (!defined('DB_PORT')) {
    define('DB_PORT', 3306);
}
if (!defined('DB_DATABASE')) {
    define('DB_DATABASE', 'bd_fundicion');
}

// Variables compatibles con implementación anterior
$servidor = DB_HOST;
$usuario = DB_USER;
$clave = DB_PASSWORD;
$puerto = DB_PORT;
$baseDatos = DB_DATABASE;

?>