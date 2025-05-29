<?php

namespace app\models;

use app\classes\DB;

class Proveedor extends DB
{
    protected $table = 'proveedores';
    protected $tableAlias = null;
    protected $fromWithAlias = false;

    public function __construct()
    {
        parent::__construct();
        $this->connect(); // Inicializa $this->conex
        $this->tableAlias = 'proveedores';
        $this->fromWithAlias = true;
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'proveedor_id');
    }

    public function count($c = '*')
    {
        $sql = "SELECT COUNT($c) as total FROM proveedores";
        $result = $this->conex->query($sql);
        $row = $result ? $result->fetch_assoc() : ['total' => 0];
        return (int)($row['total'] ?? 0);
    }

    public function deleteWithProducts($id)
    {
        try {
            // Eliminar los productos asociados al proveedor
            $sqlProductos = "DELETE FROM productos WHERE id_proveedor = ?";
            $stmtProductos = $this->conex->prepare($sqlProductos);
            $stmtProductos->bind_param('i', $id);
            $stmtProductos->execute();

            // Eliminar el proveedor
            $sqlProveedor = "DELETE FROM proveedores WHERE id_proveedor = ?";
            $stmtProveedor = $this->conex->prepare($sqlProveedor);
            $stmtProveedor->bind_param('i', $id);
            $stmtProveedor->execute();

            return $stmtProveedor->affected_rows > 0;
        } catch (\Exception $e) {
            error_log('Error en Proveedor@deleteWithProducts: ' . $e->getMessage());
            throw $e;
        }
    }
}
