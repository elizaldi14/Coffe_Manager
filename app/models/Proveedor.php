<?php

namespace app\models;

use app\classes\DB;

class Proveedor extends DB {
    protected $table = 'proveedores';
    protected $tableAlias = null;
    protected $fromWithAlias = false;

    public function __construct() {
        parent::__construct();
        $this->connect(); // Inicializa $this->conex
        $this->tableAlias = 'proveedores';
        $this->fromWithAlias = true;
    }
    
    public function productos() {
        return $this->hasMany(Producto::class, 'proveedor_id');
    }

    public function count($c = '*') {
        $sql = "SELECT COUNT($c) as total FROM proveedores";
        $result = $this->conex->query($sql);
        $row = $result ? $result->fetch_assoc() : ['total' => 0];
        return $row['total'] ?? 0;
    }
}
