<?php
require_once __DIR__ . '/../models/ProductoModel.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

class ProductoController {
    private $db;
    private $model;

    public function __construct($db) {
        $this->db = $db;
        $this->model = new ProductoModel($db);
    }

    /**
     * Lista todos los productos
     */
    public function index() {
        try {
            // Verificar y crear tablas si no existen
            if (!$this->model->verificarDatos()) {
                throw new Exception('Error al verificar las tablas de la base de datos');
            }

            // Obtener productos activos
            $productos = $this->model->obtenerTodos();
            
            // Obtener categorías activas
            $categorias = $this->model->obtenerCategorias();
            
            // Obtener proveedores activos
            $proveedores = $this->model->obtenerProveedores();
            
            // Verificar si hay datos necesarios
            if (empty($categorias)) {
                throw new Exception('No hay categorías disponibles. Por favor, crea al menos una categoría.');
            }
            if (empty($proveedores)) {
                throw new Exception('No hay proveedores disponibles. Por favor, crea al menos un proveedor.');
            }
            
            return [
                'productos' => $productos,
                'categorias' => $categorias,
                'proveedores' => $proveedores
            ];
            
        } catch (Exception $e) {
            error_log('Error en ProductoController@index: ' . $e->getMessage());
            return [
                'error' => $e->getMessage(),
                'productos' => [],
                'categorias' => [],
                'proveedores' => []
            ];
        }
    }

    /**
     * Muestra el formulario para crear un nuevo producto
     */
    public function crear() {
        try {
            $categorias = $this->model->obtenerCategorias();
            error_log('Categorías obtenidas: ' . print_r($categorias, true));
            $proveedores = $this->model->obtenerProveedores();
            error_log('Proveedores obtenidos: ' . print_r($proveedores, true));
            
            return [
                'categorias' => $categorias,
                'proveedores' => $proveedores
            ];
            
        } catch (Exception $e) {
            error_log('Error en ProductoController@crear: ' . $e->getMessage());
            return [
                'error' => 'Error al cargar el formulario',
                'categorias' => [],
                'proveedores' => []
            ];
        }
    }

    /**
     * Crea un nuevo producto
     */
    public function guardar() {
        // Establecer el encabezado de respuesta como JSON
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
            exit;
        }

        try {
            // Validar datos de entrada
            $datos = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'precio' => (float)($_POST['precio'] ?? 0),
                'stock' => (int)($_POST['stock'] ?? 0),
                'stock_minimo' => (int)($_POST['stock_minimo'] ?? 0),
                'categoria_id' => (int)($_POST['categoria_id'] ?? 0),
                'proveedor_id' => !empty($_POST['proveedor_id']) ? (int)$_POST['proveedor_id'] : null
            ];

            // Validaciones básicas
            if (empty($datos['nombre'])) {
                http_response_code(400);
                echo json_encode(['error' => 'El nombre del producto es obligatorio']);
                exit;
            }

            if ($datos['precio'] <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'El precio debe ser mayor a cero']);
                exit;
            }


            if ($datos['categoria_id'] <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Debe seleccionar una categoría válida']);
                exit;
            }

            // Validar que el stock no sea menor que el stock mínimo
            if ($datos['stock'] < $datos['stock_minimo']) {
                http_response_code(400);
                echo json_encode(['error' => 'El stock no puede ser menor al stock mínimo']);
                exit;
            }

            // Crear el producto
            $productoId = $this->model->crear($datos);
            
            if ($productoId === false) {
                error_log('Error al crear el producto - El modelo devolvió false');
                http_response_code(500);
                echo json_encode(['error' => 'Error al crear el producto. Por favor, verifica los datos e inténtalo de nuevo.']);
                exit;
            }

            // Éxito
            error_log("Producto creado exitosamente con ID: $productoId");
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Producto creado correctamente',
                'producto_id' => $productoId
            ]);
            exit;
            
        } catch (Exception $e) {
            error_log('Error en ProductoController@guardar: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
            exit;
        }
    }

    /**
     * Muestra el formulario para editar un producto
     */
    public function editar($id) {
        try {
            $producto = $this->model->obtenerPorId($id);
            $categorias = $this->model->obtenerCategorias();
            $proveedores = $this->model->obtenerProveedores();
            
            if (!$producto) {
                throw new Exception('Producto no encontrado');
            }
            
            return [
                'producto' => $producto,
                'categorias' => $categorias,
                'proveedores' => $proveedores
            ];
            
        } catch (Exception $e) {
            error_log('Error en ProductoController@editar: ' . $e->getMessage());
            return [
                'error' => $e->getMessage(),
                'producto' => null,
                'categorias' => [],
                'proveedores' => []
            ];
        }
    }

    /**
     * Actualiza un producto existente
     */
    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.1 405 Method Not Allowed');
            return ['error' => 'Método no permitido'];
        }

        try {
            // Validar ID
            if (!is_numeric($id) || $id <= 0) {
                return ['error' => 'ID de producto no válido'];
            }

            // Validar que el producto exista
            $producto = $this->model->obtenerPorId($id);
            if (!$producto) {
                return ['error' => 'Producto no encontrado'];
            }

            // Validar datos de entrada
            $datos = [
                'nombre' => $_POST['nombre'] ?? $producto['nombre'],
                'precio' => isset($_POST['precio']) ? (float)$_POST['precio'] : $producto['precio'],
                'stock' => isset($_POST['stock']) ? (int)$_POST['stock'] : $producto['stock'],
                'stock_minimo' => isset($_POST['stock_minimo']) ? (int)$_POST['stock_minimo'] : $producto['stock_minimo'],
                'categoria_id' => isset($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : $producto['categoria']['id'],
                'proveedor_id' => !empty($_POST['proveedor_id']) ? (int)$_POST['proveedor_id'] : $producto['proveedor']['id']
            ];

            // Validaciones básicas
            if (empty($datos['nombre'])) {
                return ['error' => 'El nombre del producto es obligatorio'];
            }

            if ($datos['precio'] <= 0) {
                return ['error' => 'El precio debe ser mayor a cero'];
            }

            if ($datos['categoria_id'] <= 0) {
                return ['error' => 'Debe seleccionar una categoría válida'];
            }

            // Actualizar el producto
            $exito = $this->model->actualizar($id, $datos);
            
            if (!$exito) {
                return ['error' => 'Error al actualizar el producto'];
            }

            return ['success' => 'Producto actualizado correctamente'];
            
        } catch (Exception $e) {
            error_log('Error en ProductoController@actualizar: ' . $e->getMessage());
            return ['error' => 'Error al procesar la solicitud'];
        }
    }

    /**
     * Elimina un producto
     */
    public function eliminar($id) {
        try {
            $resultado = $this->model->eliminar($id);
            
            if ($resultado) {
                return ['success' => 'Producto eliminado correctamente'];
            } else {
                throw new Exception('No se pudo eliminar el producto');
            }
            
        } catch (Exception $e) {
            error_log('Error en ProductoController@eliminar: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}