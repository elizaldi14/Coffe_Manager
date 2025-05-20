<?php

namespace app\models;

use app\classes\DB;

class Producto extends Model {
    protected $table = 'productos';
    
    public function __construct() {
        parent::__construct();
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
}
