<?php

namespace app\controllers;

use app\classes\DB;
use app\models\Categoria;
use app\classes\View;

class CategoriaController extends Controller
{
    private $db; // Define la propiedad $db

    public function __construct()
    {
        parent::__construct();
        $this->db = new DB(); // Inicializa la conexión a la base de datos
        $this->db->connect(); // Conecta a la base de datos
    }

    public function index()
    {
        View::render('categoria/categories', [
            'title' => 'Gestión de Categorías'
        ]);
    }

    public function list()
    {
        $cat = new Categoria();
        echo json_encode($cat->all()->get());
    }

    public function store()
    {
        $cat = new Categoria();
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        // Asegura que los campos existan y usa los nombres correctos según tu formulario
        $nombre = $data['nombre_categoria'] ?? '';
        $descripcion = $data['descripcion'] ?? '';
        $activa = isset($data['activa']) ? $data['activa'] : 1;

        // Valida que al menos el nombre esté presente
        if (empty($nombre)) {
            echo json_encode(['error' => 'El nombre de la categoría es obligatorio.']);
            return;
        }

        $cat->fillable = ['nombre_categoria', 'descripcion', 'activa'];
        $cat->values = [$nombre, $descripcion, $activa];
        $cat->create();
        echo json_encode(['success' => true]);
    }

    public function update($params)
    {
        $id = $params[2] ?? null;
        $cat = new Categoria();
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        // Implementa tu método update en el modelo
        $cat->update($id, $data);
        echo json_encode(['success' => true]);
    }

    public function delete($params)
    {
        $id = $params[2] ?? null;

        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de categoría no válido o no proporcionado']);
            return;
        }

        try {
            $cat = new Categoria();
            if ($cat->deleteWithProducts($id)) {
                echo json_encode(['success' => true, 'message' => 'Categoría y productos asociados eliminados correctamente']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Categoría no encontrada']);
            }
        } catch (\Exception $e) {
            error_log('Error en CategoriaController@delete: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar la categoría: ' . $e->getMessage()]);
        }
    }
}
