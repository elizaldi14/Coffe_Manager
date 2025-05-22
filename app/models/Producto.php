<?php

namespace app\models;

use app\classes\DB;

class Producto extends DB {
    protected $table = 'productos';
    protected $tableAlias = null;
    protected $fromWithAlias = false;

    public function __construct() {
        parent::__construct();
        $this->connect(); // Esto inicializa $this->conex en DB
        $this->tableAlias = 'productos';
        $this->fromWithAlias = true;
    }

    // Sobrescribe el método all() para poner el alias en el FROM
    public function all() {
        $this->fromWithAlias = true;
        return $this;
    }
    
    public function categoria() {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    
    public function proveedor() {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
    
    public function bajoStock() {
        return $this->where('stock', '<=', 'stock_minimo')->get();
    }

    public function count($c = '*') {
        // Usa $this->conex que es la conexión activa de mysqli
        $sql = "SELECT COUNT($c) as total FROM productos";
        $result = $this->conex->query($sql);
        $row = $result ? $result->fetch_assoc() : ['total' => 0];
        return $row['total'] ?? 0;
    }

    public function update($id, $data) {
        if (!is_array($data) || empty($data)) {
            throw new \InvalidArgumentException('Los datos deben ser un array no vacío');
        }
        
        $allowedFields = ['nombre', 'descripcion', 'precio', 'stock', 'stock_minimo', 'categoria_id', 'proveedor_id'];
        $fields = [];
        $values = [];
        $types = '';

        foreach ($data as $key => $value) {
            if (!in_array($key, $allowedFields)) {
                continue; // Skip fields that are not in the allowed list
            }
            
            $fields[] = "`$key` = ?";
            $values[] = $value;
            $types .= is_int($value) ? 'i' : (is_float($value) ? 'd' : 's');
        }

        if (empty($fields)) {
            throw new \InvalidArgumentException('No se proporcionaron campos válidos para actualizar');
        }

        $sql = "UPDATE `{$this->table}` SET " . implode(", ", $fields) . " WHERE `id_producto` = ?";
        $values[] = $id;
        $types .= is_numeric($id) ? 'i' : 's';

        // Log the SQL query for debugging (remove in production)
        error_log("Executing SQL: $sql");
        error_log("With values: " . print_r($values, true));
        error_log("With types: $types");

        $stmt = $this->conex->prepare($sql);
        if ($stmt === false) {
            throw new \RuntimeException('Error al preparar la consulta: ' . $this->conex->error);
        }
        
        // Bind parameters dynamically
        $bindParams = [$types];
        $bindParams = array_merge($bindParams, $this->refValues($values));
        
        call_user_func_array([$stmt, 'bind_param'], $bindParams);
        
        $result = $stmt->execute();
        $affectedRows = $stmt->affected_rows;
        $stmt->close();
        
        return $affectedRows > 0;
    }
    
    /**
     * Helper method to prepare values for bind_param
     */
    private function refValues($arr) {
        $refs = [];
        foreach ($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }

}