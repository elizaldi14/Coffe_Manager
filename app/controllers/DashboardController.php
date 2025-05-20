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
        
        if (!isset($_SESSION['nombre'])) {
            // Si es una petición AJAX, devolver error 401
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado']);
                exit();
            } else {
                // Si no es AJAX, redirigir al login
                header('Location: /Session/iniSession');
                exit();
            }
        }
    }
    
    /**
     * Muestra la vista principal del dashboard
     */
    public function index() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['sv']) || $_SESSION['sv'] !== true) {
            header('Location: /Session/iniSession');
            exit();
        }
        
        // Obtener datos para el dashboard
        $producto = new ProductoModel();
        
        // Definir la ruta de la vista (relativa al directorio de vistas)
        $viewPath = 'dashboard/index';
        
        // Construir la ruta completa al archivo de vista
        $viewFile = VIEWS . str_replace('/', DIRECTORY_SEPARATOR, $viewPath) . '.php';
        
        // Verificar si el archivo de vista existe
        if (!file_exists($viewFile)) {
            die("No se encontró la vista: " . $viewFile);
        }
        
        // Renderizar la vista del dashboard
        View::render($viewPath, [
            'title' => 'Panel de Control',
            'usuario' => [
                'nombre' => $_SESSION['nombre'] ?? 'Usuario',
                'rol' => $_SESSION['rol'] ?? 'usuario'
            ],
            'productCount' => 0, // Valor temporal, puedes reemplazarlo con el conteo real
            'categoryCount' => 0, // Valor temporal, puedes reemplazarlo con el conteo real
            'userCount' => 0 // Valor temporal, puedes reemplazarlo con el conteo real
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
