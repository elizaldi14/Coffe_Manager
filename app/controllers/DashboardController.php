<?php

namespace app\controllers;

use app\models\Producto as ProductoModel;
use app\classes\View as View;

class DashboardController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->checkAuth();
    }
    
    /**
     * Verifica si el usuario está autenticado
     * Si no está autenticado, redirige al login
     */
    private function checkAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario'])) {
            // Si es una petición AJAX, devolver error 401
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado']);
                exit();
            } else {
                // Si no es AJAX, redirigir al login
                header('Location: ' . URL . 'auth/login');
                exit();
            }
        }
    }
    
    /**
     * Muestra la vista principal del dashboard
     */
    public function index() {
        // Obtener datos para el dashboard
        $producto = new ProductoModel();
        
        // Renderizar la vista del dashboard
        View::render('dashboard/index', [
            'title' => 'Panel de Control',
            'usuario' => $_SESSION['usuario']
        ]);
    }
    
    /**
     * Obtiene los datos del dashboard (API)
     */
    public function getData() {
        // Verificar que sea una petición AJAX
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso no permitido']);
            return;
        }
        
        // Obtener datos del dashboard
        $producto = new ProductoModel();
        
        try {
            $bajoStock = $producto->bajoStock();
            
            $data = [
                'bajo_stock' => $bajoStock,
                'total_productos' => $producto->count(),
                'total_categorias' => (new \app\models\Categoria())->count(),
                'total_proveedores' => (new \app\models\Proveedor())->count(),
                'productos_por_categoria' => $this->getProductosPorCategoria()
            ];
            
            echo json_encode([
                'success' => true,
                'data' => $data
            ]);
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Error al cargar los datos del dashboard',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Obtiene la cantidad de productos por categoría
     */
    private function getProductosPorCategoria() {
        $categoria = new \app\models\Categoria();
        $categorias = $categoria->all();
        $producto = new ProductoModel();
        
        $result = [];
        
        foreach ($categorias as $cat) {
            $count = $producto->where('categoria_id', $cat->id)->count();
            $result[] = [
                'categoria' => $cat->nombre,
                'total' => $count
            ];
        }
        
        return $result;
    }
}
