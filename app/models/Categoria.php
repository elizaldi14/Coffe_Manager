<?php

namespace app\models;

use app\classes\DB;

class Categoria extends Model {
    protected $table = 'categorias';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function productos() {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}
