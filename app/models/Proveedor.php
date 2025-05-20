<?php

namespace app\models;

use app\classes\DB;

class Proveedor extends Model {
    protected $table = 'proveedores';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function productos() {
        return $this->hasMany(Producto::class, 'proveedor_id');
    }
}
