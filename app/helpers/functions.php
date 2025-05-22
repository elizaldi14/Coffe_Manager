<?php
/**
 * Función para cargar una vista
 */
function view($view, $data = []) {
    // Extraer las variables del array asociativo
    extract($data);
    
    // Incluir el archivo de la vista
    $viewPath = __DIR__ . "/../views/{$view}.php";
    
    if (file_exists($viewPath)) {
        require_once $viewPath;
    } else {
        throw new Exception("La vista {$view} no existe");
    }
}

/**
 * Función para redirigir a una URL
 */
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit();
}

/**
 * Función para escapar datos de salida
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Función para cargar un modelo
 */
function model($model) {
    $modelPath = __DIR__ . "/../models/" . ucfirst($model) . "Model.php";
    
    if (file_exists($modelPath)) {
        require_once $modelPath;
        $modelClass = ucfirst($model) . 'Model';
        return new $modelClass($GLOBALS['db']);
    } else {
        throw new Exception("El modelo {$model} no existe");
    }
}
