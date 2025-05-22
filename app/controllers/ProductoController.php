<?php

namespace app\controllers;

use app\models\Producto as ProductoModel;
use app\classes\View;

class ProductoController extends Controller {
    
    private $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = new ProductoModel();
    }

    public function index() {
        // Cambia 'producto/index' por 'producto/products' para que coincida con el archivo real
        View::render('producto/products', [
            'title' => 'Gestión de Productos'
        ]);
    }

    public function show($params) {
        $id = $params[2] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de producto no proporcionado']);
            return;
        }
        // Consulta simple por id_producto
        $producto = $this->model
            ->select([
                'productos.id_producto',
                'productos.nombre_producto',
                'productos.precio',
                'productos.stock',
                'productos.stock_minimo',
                'c.nombre_categoria as categoria',
                'p.nombre_empresa as proveedor'
            ])
            ->join('categorias c', 'productos.id_categoria = c.id_categoria')
            ->join('proveedores p', 'productos.id_proveedor = p.id_proveedor')
            ->where([['productos.id_producto', $id]])
            ->all()
            ->get();
        echo $producto;
    }

    public function store() {
        // Recibe datos por POST tradicional (formulario)
        $data = $_POST;
        // Validación básica
        if (empty($data['nombre_producto']) || empty($data['precio']) || !isset($data['stock'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Nombre, precio y stock son obligatorios']);
            return;
        }
        try {
            $this->model->fillable = ['id_categoria','id_proveedor','nombre_producto','precio','stock','stock_minimo','activo'];
            $this->model->values = [
                $data['id_categoria'],
                $data['id_proveedor'],
                $data['nombre_producto'],
                $data['precio'],
                $data['stock'],
                $data['stock_minimo'] ?? 0,
                1
            ];
            $id = $this->model->create();
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
        header('Content-Type: application/json');
        
        $id = $params[2] ?? null;
        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de producto no válido o no proporcionado']);
            return;
        }

        // Get the raw input
        $input = file_get_contents('php://input');
        if (empty($input)) {
            http_response_code(400);
            echo json_encode(['error' => 'No se recibieron datos para actualizar']);
            return;
        }

        // Decode JSON data
        $data = json_decode($input, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Formato JSON inválido: ' . json_last_error_msg()]);
            return;
        }

        if (empty($data)) {
            http_response_code(400);
            echo json_encode(['error' => 'Los datos no pueden estar vacíos']);
            return;
        }


        try {
            $result = $this->model->update($id, $data);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Producto actualizado correctamente']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No se pudo actualizar el producto']);
            }
        } catch (\Exception $e) {
            error_log('Error en ProductoController::update - ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar el producto', 'details' => $e->getMessage()]);
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
    
    public function list() {
        $productos = $this->model
            ->select([
                'productos.id_producto',
                'productos.nombre_producto',
                'productos.precio',
                'productos.stock',
                'productos.stock_minimo',
                'c.nombre_categoria as categoria',
                'p.nombre_empresa as proveedor'
            ])
            ->join('categorias c', 'productos.id_categoria = c.id_categoria')
            ->join('proveedores p', 'productos.id_proveedor = p.id_proveedor')
            ->all()
            ->get();
        echo $productos;
    }

    
}