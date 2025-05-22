<?php

namespace app\controllers;

use app\models\Producto as ProductoModel;
use app\models\Categoria as CategoriaModel;
use app\models\Proveedor as ProveedorModel;
use app\classes\View as View;

class DashboardController extends Controller {

    public function __construct() {
        parent::__construct();
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
        $productos = (new ProductoModel())->count();
        $categorias = (new CategoriaModel())->count();
        $proveedores = (new ProveedorModel())->count();

        echo json_encode([
            'productos' => $productos,
            'categorias' => $categorias,
            'proveedores' => $proveedores
        ]);
    }
}