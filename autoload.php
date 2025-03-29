<?php
define('APP_ROOT', '/var/www/html');

spl_autoload_register(function ($class) {
    include APP_ROOT . '/includes/' . $class . '.php';
});

// Incluir archivos no clasess
require_once APP_ROOT . '/includes/config.php';
require_once APP_ROOT . '/includes/funciones.php';