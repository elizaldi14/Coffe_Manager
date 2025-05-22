<?php
class ProductoModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Obtiene todos los productos activos
     */
    public function obtenerTodos() {
        try {
            $query = "SELECT p.* 
                     FROM productos p
                     LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
                     LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                     WHERE p.activo = 1
                     ORDER BY p.nombre_producto ASC";
            
            $result = $this->db->query($query);
            
            if (!$result) {
                throw new Exception('Error en la consulta: ' . $this->db->error);
            }
            
            $productos = [];
            while ($row = $result->fetch_assoc()) {
                $productos[] = $this->mapearProducto($row);
            }
            
            return $productos;
            
        } catch (Exception $e) {
            error_log('Error en ProductoModel@obtenerTodos: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene un producto por su ID
     */
    public function obtenerPorId($id) {
        try {
            $query = "SELECT p.* 
                     FROM productos p
                     LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
                     LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                     WHERE p.id_producto = ? AND p.activo = 1";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                return null;
            }
            
            return $this->mapearProducto($result->fetch_assoc());
            
        } catch (Exception $e) {
            error_log('Error en ProductoModel@obtenerPorId: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Crea un nuevo producto
     */
    public function crear($datos) {
        try {
            // Registrar los datos recibidos para depuración
            error_log('Datos recibidos en ProductoModel@crear: ' . print_r($datos, true));
            
            // Verificar que los campos requeridos estén presentes
            $camposRequeridos = ['nombre', 'precio', 'stock', 'stock_minimo', 'categoria_id'];
            foreach ($camposRequeridos as $campo) {
                if (!isset($datos[$campo]) || (is_string($datos[$campo]) && trim($datos[$campo]) === '')) {
                    error_log("Error: Campo requerido faltante o vacío: $campo");
                    return false;
                }
            }
            
            // Preparar la consulta SQL
            $query = "INSERT INTO productos (nombre_producto, precio, stock, stock_minimo, id_categoria, id_proveedor, activo) 
                     VALUES (?, ?, ?, ?, ?, ?, 1)";
            
            error_log("Consulta SQL: $query");
            
            // Preparar la declaración
            $stmt = $this->db->prepare($query);
            if ($stmt === false) {
                error_log('Error al preparar la consulta: ' . $this->db->error);
                return false;
            }
            
            // Vincular parámetros
            $proveedorId = !empty($datos['proveedor_id']) ? $datos['proveedor_id'] : null;
            $stmt->bind_param(
                'sddiii',
                $datos['nombre'],
                $datos['precio'],
                $datos['stock'],
                $datos['stock_minimo'],
                $datos['categoria_id'],
                $proveedorId
            );
            
            // Ejecutar la consulta
            $resultado = $stmt->execute();
            
            if (!$resultado) {
                error_log('Error al ejecutar la consulta: ' . $stmt->error);
                return false;
            }
            
            // Obtener el ID del producto insertado
            $nuevoId = $this->db->insert_id;
            error_log("Producto creado exitosamente con ID: $nuevoId");
            
            return $nuevoId;
            
        } catch (Exception $e) {
            error_log('Error en ProductoModel@crear: ' . $e->getMessage() . ' en ' . $e->getFile() . ':' . $e->getLine());
            return false;
        }
    }

    /**
     * Verifica la conexión y obtiene datos
     */
    /**
     * Obtiene todas las categorías activas
     */
    public function obtenerCategorias() {
        try {
            $query = "SELECT id_categoria, nombre_categoria 
                     FROM categorias 
                     WHERE activo = 1 
                     ORDER BY nombre_categoria ASC";
            
            $result = $this->db->query($query);
            
            if (!$result) {
                throw new Exception('Error en la consulta: ' . $this->db->error);
            }
            
            $categorias = [];
            while ($row = $result->fetch_assoc()) {
                $categorias[] = [
                    'id' => $row['id_categoria'],
                    'nombre' => $row['nombre_categoria']
                ];
            }
            
            return $categorias;
            
        } catch (Exception $e) {
            error_log('Error en ProductoModel@obtenerCategorias: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene todos los proveedores activos
     */
    public function obtenerProveedores() {
        try {
            $query = "SELECT id_proveedor, nombre_empresa 
                     FROM proveedores 
                     WHERE activo = 1 
                     ORDER BY nombre_empresa ASC";
            
            $result = $this->db->query($query);
            
            if (!$result) {
                throw new Exception('Error en la consulta: ' . $this->db->error);
            }
            
            $proveedores = [];
            while ($row = $result->fetch_assoc()) {
                $proveedores[] = [
                    'id' => $row['id_proveedor'],
                    'nombre_empresa' => $row['nombre_empresa']
                ];
            }
            
            return $proveedores;
            
        } catch (Exception $e) {
            error_log('Error en ProductoModel@obtenerProveedores: ' . $e->getMessage());
            return [];
        }
    }

    public function verificarDatos() {
        try {
            // Verificar conexión
            if (!$this->db->ping()) {
                error_log('Error: No se pudo conectar a la base de datos');
                return false;
            }

            // Crear tabla categorias si no existe
            $sql = "CREATE TABLE IF NOT EXISTS categorias (
                id_categoria INT AUTO_INCREMENT PRIMARY KEY,
                nombre_categoria VARCHAR(100) NOT NULL,
                activo TINYINT(1) DEFAULT 1,
                creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            if (!$this->db->query($sql)) {
                error_log('Error al crear tabla categorias: ' . $this->db->error);
            }

            // Crear tabla proveedores si no existe
            $sql = "CREATE TABLE IF NOT EXISTS proveedores (
                id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
                nombre_empresa VARCHAR(100) NOT NULL,
                activo TINYINT(1) DEFAULT 1,
                creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            if (!$this->db->query($sql)) {
                error_log('Error al crear tabla proveedores: ' . $this->db->error);
            }

            // Crear tabla productos si no existe
            $sql = "CREATE TABLE IF NOT EXISTS productos (
                id_producto INT AUTO_INCREMENT PRIMARY KEY,
                nombre_producto VARCHAR(100) NOT NULL,
                precio DECIMAL(10,2) NOT NULL,
                stock INT NOT NULL DEFAULT 0,
                stock_minimo INT NOT NULL DEFAULT 0,
                id_categoria INT,
                id_proveedor INT,
                activo TINYINT(1) DEFAULT 1,
                creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_producto_categoria FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
                CONSTRAINT fk_producto_proveedor FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor)
            )";
            if (!$this->db->query($sql)) {
                error_log('Error al crear tabla productos: ' . $this->db->error);
            }

            // Insertar datos de prueba si no existen
            $sql = "INSERT IGNORE INTO categorias (nombre_categoria, activo) VALUES 
                ('Bebidas Calientes', 1),
                ('Bebidas Frías', 1),
                ('Panadería', 1),
                ('Alimentos', 1),
                ('Postres', 1)";
            if (!$this->db->query($sql)) {
                error_log('Error al insertar datos de prueba en categorias: ' . $this->db->error);
            }

            $sql = "INSERT IGNORE INTO proveedores (nombre_empresa, activo) VALUES 
                ('Café Especial S.A.', 1),
                ('Dulces Delicias', 1),
                ('Alimentos Frescos', 1),
                ('Lácteos del Valle', 1)";
            if (!$this->db->query($sql)) {
                error_log('Error al insertar datos de prueba en proveedores: ' . $this->db->error);
            }

            return true;
        } catch (Exception $e) {
            error_log('Error en ProductoModel@verificarDatos: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza un producto existente
     */
    public function actualizar($id, $datos) {
        try {
            $query = "UPDATE productos 
                     SET nombre_producto = ?, 
                         precio = ?, 
                         stock = ?, 
                         stock_minimo = ?, 
                         id_categoria = ?, 
                         id_proveedor = ?
                     WHERE id_producto = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param(
                'sddiiii',
                $datos['nombre'],
                $datos['precio'],
                $datos['stock'],
                $datos['stock_minimo'],
                $datos['categoria_id'],
                $datos['proveedor_id'],
                $id
            );
            
            if (!$stmt->execute()) {
                throw new Exception('Error al actualizar el producto: ' . $stmt->error);
            }
            
            return $stmt->affected_rows > 0;
            
        } catch (Exception $e) {
            error_log('Error en ProductoModel@actualizar: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un producto (borrado lógico)
     */
    public function eliminar($id) {
        try {
            $query = "UPDATE productos SET activo = 0 WHERE id_producto = ?";
            
            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                throw new Exception('Error al preparar la consulta: ' . $this->db->error);
            }
            
            $stmt->bind_param('i', $id);
            
            if (!$stmt->execute()) {
                throw new Exception('Error al eliminar el producto: ' . $stmt->error);
            }
            
            return $stmt->affected_rows > 0;
            
        } catch (Exception $e) {
            error_log('Error en ProductoModel@eliminar: ' . $e->getMessage());
            return false;
        }
    }



    /**
     * Mapea los datos del producto a un array asociativo
     */
    private function mapearProducto($row) {
        return [
            'id' => (int)$row['id_producto'],
            'nombre' => $row['nombre_producto'],
            'precio' => (float)$row['precio'],
            'stock' => (int)$row['stock'],
            'stock_minimo' => (int)$row['stock_minimo'],
            'activo' => (bool)$row['activo'],
            'categoria' => [
                'id' => (int)$row['id_categoria'],
                'nombre' => $row['categoria_nombre'] ?? 'Sin categoría'
            ],
            'proveedor' => [
                'id' => $row['id_proveedor'] ? (int)$row['id_proveedor'] : null,
                'nombre' => $row['proveedor_nombre'] ?? 'Sin proveedor'
            ],
            'fecha_creacion' => $row['fecha_creacion']
        ];
    }

    /**
     * Verifica si las tablas existen y tienen datos
     */
    public function verificarTablas() {
        try {
            // Verificar categorías
            $queryCategorias = "SELECT COUNT(*) as total FROM categorias";
            $resultCategorias = $this->db->query($queryCategorias);
            $rowCategorias = $resultCategorias->fetch_assoc();
            
            // Verificar proveedores
            $queryProveedores = "SELECT COUNT(*) as total FROM proveedores";
            $resultProveedores = $this->db->query($queryProveedores);
            $rowProveedores = $resultProveedores->fetch_assoc();
            
            error_log('Verificación de tablas: ');
            error_log('Tablas categorias: ' . ($resultCategorias ? 'Existe' : 'No existe'));
            error_log('Registros categorias: ' . ($rowCategorias ? $rowCategorias['total'] : '0'));
            error_log('Tablas proveedores: ' . ($resultProveedores ? 'Existe' : 'No existe'));
            error_log('Registros proveedores: ' . ($rowProveedores ? $rowProveedores['total'] : '0'));
            
            return [
                'categorias' => [
                    'existe' => $resultCategorias !== false,
                    'registros' => $rowCategorias ? $rowCategorias['total'] : 0
                ],
                'proveedores' => [
                    'existe' => $resultProveedores !== false,
                    'registros' => $rowProveedores ? $rowProveedores['total'] : 0
                ]
            ];
            
        } catch (Exception $e) {
            error_log('Error en ProductoModel@verificarTablas: ' . $e->getMessage());
            return [
                'categorias' => [
                    'existe' => false,
                    'registros' => 0
                ],
                'proveedores' => [
                    'existe' => false,
                    'registros' => 0
                ]
            ];
        }
    }
}
