<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar configuración
require_once __DIR__ . '/../config.php';

// Cargar la clase DB
require_once __DIR__ . '/classes/DB.php';

// Obtener instancia de la conexión a la base de datos
$db = DB::getInstance()->getConnection();

// Cargar modelos
require_once __DIR__ . '/models/DashboardModel.php';
require_once __DIR__ . '/models/ProductoModel.php';

// Cargar controladores
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/ProductoController.php';

// Inicializar controladores con la conexión a la base de datos
$dashboardController = new DashboardController($db);
$productoController = new ProductoController($db);
