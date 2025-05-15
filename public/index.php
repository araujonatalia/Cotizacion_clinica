<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/app.php'; // Aquí defines la conexión PDO

$controller = $_GET['controller'] ?? '';
$method = $_GET['method'] ?? '';

if ($controller === 'cotizacion') {
    $controllerClass = 'App\\Controllers\\CotizacionControllers';
    $instance = new $controllerClass;

    if (method_exists($instance, $method)) {
        $instance->$method();
    } else {
        echo 'Método no encontrado';
    }
}

