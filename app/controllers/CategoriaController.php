<?php

namespace app\controllers;

use app\classes\View;

class CategoriaController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Verificar autenticación si es necesario
        $this->checkAuth();
    }

    /**
     * Muestra la lista de categorías
     */
    public function index()
    {
        // Aquí iría la lógica para obtener las categorías
        $data = [
            'title' => 'Categorías',
            'active' => 'categories',
            'categorias' => [] // Datos de ejemplo
        ];
        
        View::render('categorias/index', $data);
    }

    /**
     * Verifica si el usuario está autenticado
     */
    private function checkAuth()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['sv']) || $_SESSION['sv'] !== true) {
            header('Location: /Session/iniSession');
            exit();
        }
    }
}
