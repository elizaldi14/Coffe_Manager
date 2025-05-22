<?php

namespace app\models;

use app\classes\DB;

class Categoria extends DB {
    protected $table = 'categorias';
    protected $tableAlias = null;
    protected $fromWithAlias = false;

    public function __construct() {
        parent::__construct();
        $this->connect(); // Inicializa $this->conex
        $this->tableAlias = 'categorias';
        $this->fromWithAlias = true;
    }

    public function productos() {
        return $this->hasMany(Producto::class, 'categoria_id');
    }

    public function count($c = '*') {
        $sql = "SELECT COUNT($c) as total FROM categorias";
        $result = $this->conex->query($sql);
        $row = $result ? $result->fetch_assoc() : ['total' => 0];
        return $row['total'] ?? 0;
    }

   public function update($id, $data) {
    if (empty($data)) {
        return false;
    }

    $fields = [];
    $values = [];

    foreach ($data as $key => $value) {
        $fields[] = "$key = ?";
        $values[] = $value;
    }

    // Usa la clave primaria correcta
    $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id_categoria = ?";
    $stmt = $this->conex->prepare($sql);

    if (!$stmt) {
        throw new \Exception("Error en la preparación de la consulta: " . $this->conex->error);
    }

    $types = str_repeat('s', count($values)) . 'i';
    $values[] = $id;

    $stmt->bind_param($types, ...$this->refValues($values));

    return $stmt->execute();
}


    // Helper para referencias
    private function refValues($arr) {
        $refs = [];
        foreach ($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }
}