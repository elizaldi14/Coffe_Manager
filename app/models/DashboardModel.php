<?php
class DashboardModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getTotalProductos() {
        try {
            $query = "SELECT COUNT(id_producto) as total FROM productos WHERE activo = 1";
            error_log('SQL getTotalProductos: ' . $query);
            
            $result = $this->db->query($query);
            if (!$result) {
                throw new Exception('Error en la consulta: ' . $this->db->error);
            }
            
            $row = $result->fetch_assoc();
            return (int)$row['total'];
            
        } catch (Exception $e) {
            error_log('Error en getTotalProductos: ' . $e->getMessage());
            return 0;
        }
    }

    public function getTotalCategorias() {
        try {
            $query = "SELECT COUNT(id_categoria) as total FROM categorias WHERE activa = 1";
            error_log('SQL getTotalCategorias: ' . $query);
            
            $result = $this->db->query($query);
            if (!$result) {
                throw new Exception('Error en la consulta: ' . $this->db->error);
            }
            
            $row = $result->fetch_assoc();
            return (int)$row['total'];
            
        } catch (Exception $e) {
            error_log('Error en getTotalCategorias: ' . $e->getMessage());
            return 0;
        }
    }

    public function getTotalProveedores() {
        try {
            $query = "SELECT COUNT(id_proveedor) as total FROM proveedores WHERE activo = 1";
            error_log('SQL getTotalProveedores: ' . $query);
            
            $result = $this->db->query($query);
            if (!$result) {
                throw new Exception('Error en la consulta: ' . $this->db->error);
            }
            
            $row = $result->fetch_assoc();
            return (int)$row['total'];
            
        } catch (Exception $e) {
            error_log('Error en getTotalProveedores: ' . $e->getMessage());
            return 0;
        }
    }

    public function getProductosBajoStock($limite = 5) {
        try {
            $query = "SELECT p.id_producto, p.nombre_producto, p.stock, p.stock_minimo 
                     FROM productos p 
                     WHERE p.stock <= p.stock_minimo 
                     AND p.activo = 1 
                     ORDER BY p.stock ASC 
                     LIMIT ?";
            
            error_log('SQL getProductosBajoStock: ' . str_replace('?', $limite, $query));
            
            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                throw new Exception('Error al preparar la consulta: ' . $this->db->error);
            }
            
            $stmt->bind_param('i', $limite);
            if (!$stmt->execute()) {
                throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
            }
            
            $result = $stmt->get_result();
            $productos = [];
            
            while ($row = $result->fetch_assoc()) {
                $productos[] = [
                    'id_producto' => $row['id_producto'],
                    'nombre_producto' => $row['nombre_producto'],
                    'stock' => (int)$row['stock'],
                    'stock_minimo' => (int)$row['stock_minimo']
                ];
            }
            
            return $productos;
            
        } catch (Exception $e) {
            error_log('Error en getProductosBajoStock: ' . $e->getMessage());
            return [];
        }
    }
}
