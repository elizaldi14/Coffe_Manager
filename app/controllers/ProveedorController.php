<?php

namespace app\controllers;

use app\classes\View;

class ProveedorController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Verificar autenticación
        $this->checkAuth();
    }

    /**
     * Muestra la lista de proveedores
     */
    public function index()
    {
        // Aquí iría la lógica para obtener los proveedores
        $data = [
            'title' => 'Proveedores',
            'active' => 'suppliers',
            'proveedores' => [] // Datos de ejemplo
        ];
        
        View::render('proveedores/index', $data);
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
