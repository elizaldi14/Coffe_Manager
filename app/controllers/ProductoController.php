<?php

namespace app\controllers;

use app\models\ProductoModel; // Asegúrate de que este use sea correcto
use app\classes\DB;
use app\classes\View;

class ProductoController extends Controller
{
    private $db; // Define la propiedad $db
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->db = new DB(); // Inicializa la conexión a la base de datos
        $this->db->connect(); // Conecta a la base de datos
        $this->model = new ProductoModel($this->db); // Pasa la conexión al modelo
    }

    public function index()
    {
        // Cambia 'producto/index' por 'producto/products' para que coincida con el archivo real
        View::render('producto/products', [
            'title' => 'Gestión de Productos'
        ]);
    }

    public function show($params)
    {
        header('Content-Type: application/json');
        $id = $params[2] ?? null;
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de producto no proporcionado']);
            return;
        }

        try {
            // Consulta simple por id_producto
            $producto = $this->model
                ->select([
                    'productos.id_producto',
                    'productos.nombre_producto',
                    'productos.precio',
                    'productos.stock',
                    'productos.stock_minimo',
                    'productos.id_categoria',
                    'productos.id_proveedor',
                    'c.nombre_categoria as categoria_nombre',
                    'p.nombre_empresa as proveedor_nombre'
                ])
                ->join('categorias c', 'productos.id_categoria = c.id_categoria')
                ->join('proveedores p', 'productos.id_proveedor = p.id_proveedor')
                ->where([['productos.id_producto', $id]])
                ->first();

            if ($producto) {
                echo json_encode([
                    'success' => true,
                    'data' => $producto
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'error' => 'Producto no encontrado'
                ]);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Error al obtener el producto: ' . $e->getMessage()
            ]);
        }
    }

    public function store()
    {
        // Recibe datos por POST tradicional (formulario)
        $data = $_POST;
        
        // Validación básica
        if (empty($data['nombre']) || empty($data['precio']) || !isset($data['stock'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Nombre, precio y stock son obligatorios']);
            return;
        }
        
        try {
            // Preparar los datos para insertar
            $datosProducto = [
                'nombre' => $data['nombre'],
                'precio' => $data['precio'],
                'stock' => $data['stock'],
                'stock_minimo' => $data['stock_minimo'] ?? 0,
                'categoria_id' => $data['categoria'] ?? null,
                'proveedor_id' => $data['proveedor'] ?? null
            ];
            
            // Crear el producto usando el método crear del modelo
            $resultado = $this->model->crear($datosProducto);
            
            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Producto creado correctamente',
                    'id' => $resultado
                ]);
            } else {
                throw new \Exception('No se pudo crear el producto');
            }
        } catch (\Exception $e) {
            http_response_code(500);
            error_log('Error en ProductoController@store: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'error' => 'Error al crear el producto: ' . $e->getMessage()
            ]);
        }
    }

    public function update($params = [])
    {
        // Obtener los datos del formulario
        $data = $_POST;
        
        // Si se está simulando un PUT con _method=PUT, eliminar el campo _method
        if (isset($data['_method'])) {
            unset($data['_method']);
        }
        
        // Obtener el ID de los parámetros de la URL o del POST
        $id = $params['id'] ?? $data['id_producto'] ?? null;
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de producto no proporcionado']);
            return;
        }
        
        if (empty($data)) {
            http_response_code(400);
            echo json_encode(['error' => 'No se recibieron datos para actualizar']);
            return;
        }
        
        // Asegurarse de que los campos requeridos estén presentes
        $camposRequeridos = ['nombre', 'precio', 'stock'];
        foreach ($camposRequeridos as $campo) {
            if (!isset($data[$campo]) || (is_string($data[$campo]) && trim($data[$campo]) === '')) {
                http_response_code(400);
                echo json_encode(['error' => 'Nombre, precio y stock son obligatorios']);
                return;
            }
        }

        try {
            // Obtener el producto actual para comparar
            $productoActual = $this->model->obtenerPorId($id);
            if (!$productoActual) {
                http_response_code(404);
                echo json_encode(['error' => 'Producto no encontrado']);
                return;
            }

            // Mapear los nombres de los campos del formulario a los nombres de la base de datos
            $mapeoCampos = [
                'nombre' => 'nombre_producto',
                'precio' => 'precio',
                'stock' => 'stock',
                'stock_minimo' => 'stock_minimo',
                'categoria' => 'id_categoria',
                'proveedor' => 'id_proveedor'
            ];
            
            // Verificar si hay cambios reales
            $hayCambios = false;
            $datosActualizados = [];
            
            foreach ($mapeoCampos as $formField => $dbField) {
                // Verificar si el campo existe en los datos del formulario
                if (array_key_exists($formField, $data)) {
                    // Obtener el valor actual del producto
                    $valorActual = null;
                    
                    // Mapeo especial para campos anidados
                    if ($formField === 'categoria') {
                        $valorActual = is_array($productoActual['categoria'] ?? null) ? 
                                    ($productoActual['categoria']['id'] ?? null) : 
                                    ($productoActual['id_categoria'] ?? null);
                    } elseif ($formField === 'proveedor') {
                        $valorActual = is_array($productoActual['proveedor'] ?? null) ? 
                                     ($productoActual['proveedor']['id'] ?? null) : 
                                     ($productoActual['id_proveedor'] ?? null);
                    } else {
                        $valorActual = $productoActual[$dbField] ?? null;
                    }
                    
                    $valorFormulario = $data[$formField];
                    
                    // Convertir a cadena para comparación
                    $valorActualStr = (string)$valorActual;
                    $valorFormularioStr = (string)$valorFormulario;
                    
                    // Verificar si el valor es diferente al valor actual en la base de datos
                    if ($valorFormularioStr !== $valorActualStr) {
                        $hayCambios = true;
                        $datosActualizados[$dbField] = $valorFormulario;
                    }
                }
            }

            if (!$hayCambios) {
                echo json_encode(['success' => true, 'message' => 'No se realizaron cambios en el producto']);
                return;
            }

            // Actualizar el producto
            $resultado = $this->model->actualizar($id, $datosActualizados);
            
            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Producto actualizado correctamente'
                ]);
            } else {
                throw new \Exception('No se pudo actualizar el producto');
            }
        } catch (\Exception $e) {
            http_response_code(500);
            error_log('Error en ProductoController@update: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'error' => 'Error al actualizar el producto: ' . $e->getMessage()
            ]);
        }
    }


    public function delete($params)
    {
        $id = $params[2] ?? null;
        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de producto no válido o no proporcionado']);
            return;
        }

        try {
            $result = $this->model->eliminar($id); // Usa el método eliminar del modelo ProductoModel
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

    public function list()
    {
        try {
            $productos = $this->model
                ->select([
                    'p.id_producto',
                    'p.nombre_producto',
                    'p.precio',
                    'p.stock',
                    'p.stock_minimo',
                    'p.id_categoria',
                    'p.id_proveedor',
                    'c.nombre_categoria AS categoria',
                    'pr.nombre_empresa AS proveedor'
                ])
                ->all();

            echo json_encode($productos);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener la lista de productos: ' . $e->getMessage()]);
        }
    }
}