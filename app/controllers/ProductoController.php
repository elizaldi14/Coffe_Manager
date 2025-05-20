<?php

namespace app\controllers;

use app\models\Producto as ProductoModel;

class ProductoController extends Controller {
    
    private $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = new ProductoModel();
        $this->checkAuth();
    }
    
    private function checkAuth() {
        session_start();
        if (!isset($_SESSION['usuario'])) {
            http_response_code(401);
            echo json_encode(['error' => 'No autorizado']);
            exit();
        }
    }
    
    public function index() {
        $productos = $this->model->with(['categoria', 'proveedor'])->get();
        echo json_encode($productos);
    }
    
    public function show($params) {
        $id = $params[2] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de producto no proporcionado']);
            return;
        }
        
        $producto = $this->model->with(['categoria', 'proveedor'])->find($id);
        
        if ($producto) {
            echo json_encode($producto);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Producto no encontrado']);
        }
    }
    
    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validación básica
        if (empty($data['nombre']) || empty($data['precio_venta']) || empty($data['stock'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Nombre, precio de venta y stock son obligatorios']);
            return;
        }
        
        try {
            $id = $this->model->create($data);
            echo json_encode([
                'success' => true,
                'id' => $id
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear el producto: ' . $e->getMessage()]);
        }
    }
    
    public function update($params) {
        $id = $params[2] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de producto no proporcionado']);
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        try {
            $result = $this->model->update($id, $data);
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Producto no encontrado']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar el producto: ' . $e->getMessage()]);
        }
    }
    
    public function delete($params) {
        $id = $params[2] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de producto no proporcionado']);
            return;
        }
        
        try {
            $result = $this->model->delete($id);
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Producto no encontrado']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar el producto: ' . $e->getMessage()]);
        }
    }
}
