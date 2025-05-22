<?php
require_once __DIR__ . '/../models/DashboardModel.php';

class DashboardController {
    private $model;

    public function __construct($db) {
        $this->model = new DashboardModel($db);
    }

    public function index() {
        try {
            // Verificar si el usuario está logueado
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // if (!isset($_SESSION['usuario_id'])) {
            //     // Si no está logueado, redirigir al login
            //     if (!headers_sent()) {
            //         header('Location: ' . BASE_URL . '/login');
            //         exit();
            //     }
            // }

            // Verificar que el modelo esté disponible
            if (!$this->model) {
                throw new Exception('Error: Modelo no disponible');
            }

            // Obtener datos para el dashboard
            $data = [
                'total_productos' => $this->model->getTotalProductos(),
                'total_categorias' => $this->model->getTotalCategorias(),
                'total_proveedores' => $this->model->getTotalProveedores(),
                'productos_bajo_stock' => $this->model->getProductosBajoStock()
            ];

            // Validar que los datos sean válidos
            if (!is_array($data['productos_bajo_stock'])) {
                $data['productos_bajo_stock'] = [];
            }

            // Depuración
            error_log('Datos del dashboard:');
            error_log('- Total productos: ' . $data['total_productos']);
            error_log('- Total categorías: ' . $data['total_categorias']);
            error_log('- Total proveedores: ' . $data['total_proveedores']);
            error_log('- Productos bajo stock: ' . print_r($data['productos_bajo_stock'], true));

            return $data;
            
        } catch (Exception $e) {
            error_log('Error en DashboardController: ' . $e->getMessage());
            
            // Devolver datos por defecto en caso de error
            return [
                'total_productos' => 0,
                'total_categorias' => 0,
                'total_proveedores' => 0,
                'productos_bajo_stock' => []
            ];
        }
    }
}
