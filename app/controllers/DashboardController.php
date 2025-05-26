<?php

namespace app\controllers;

use app\models\ProductoModel;
use app\models\Categoria;
use app\models\Proveedor;
use app\classes\View as View;
use app\classes\DB;

class DashboardController extends Controller {
    private $db;

    public function __construct(){
        parent::__construct();
        $this->db = new DB();
        $this->db->connect();
    }

    /**
     * Muestra la vista principal del dashboard
     */
    public function index() {
        // Renderizar la vista del dashboard
        View::render('dashboard/index', [
            'title' => 'Dashboard'
        ]);
    }

    /**
     * Devuelve los totales de productos, categorías y proveedores (API)
     */
    public function getData() {
        $productos = (new ProductoModel($this->db))->count();
        $categorias = (new Categoria($this->db))->count();
        $proveedores = (new Proveedor($this->db))->count();

        echo json_encode([
            'productos' => $productos,
            'categorias' => $categorias,
            'proveedores' => $proveedores
        ]);
    }
}