<?php

namespace app\controllers;

use app\classes\View;

class ProveedorController extends Controller {

    public function index() {
        View::render('proveedor/suppliers', [
            'title' => 'Gestión de Proveedores'
        ]);
    }

    public function list() {
        $proveedor = new \app\models\Proveedor();
        // Ajusta los campos según tu estructura de tabla
        echo json_encode($proveedor->all()->get());
    }

    public function store() {
        $proveedor = new \app\models\Proveedor();
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        // Ajusta los nombres de los campos según tu formulario
        $nombre_empresa = $data['nombre_empresa'] ?? '';
        $nombre_contacto = $data['nombre_contacto'] ?? '';
        $telefono = $data['telefono'] ?? '';
        $activo = isset($data['activo']) ? $data['activo'] : 1;

        if (empty($nombre_empresa)) {
            echo json_encode(['error' => 'El nombre de la empresa es obligatorio.']);
            return;
        }

        $proveedor->fillable = ['nombre_empresa', 'nombre_contacto', 'telefono', 'activo'];
        $proveedor->values = [$nombre_empresa, $nombre_contacto, $telefono, $activo];
        $proveedor->create();
        echo json_encode(['success' => true]);
    }

    public function change() {
        $proveedor = new \app\models\Proveedor();
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $id = $data['id_proveedor'] ?? null;
        $nombre_empresa = $data['nombre_empresa'] ?? '';
        $nombre_contacto = $data['nombre_contacto'] ?? '';
        $telefono = $data['telefono'] ?? '';
        $activo = isset($data['activo']) ? $data['activo'] : 1;

        if (!$id) {
            echo json_encode(['error' => 'ID de proveedor no proporcionado.']);
            return;
        }
        if (empty($nombre_empresa)) {
            echo json_encode(['error' => 'El nombre de la empresa es obligatorio.']);
            return;
        }

        $proveedor->connect();
        $sql = "UPDATE proveedores SET nombre_empresa=?, nombre_contacto=?, telefono=?, activo=? WHERE id_proveedor=?";
        $stmt = $proveedor->conex->prepare($sql);
        $stmt->bind_param("ssssi", $nombre_empresa, $nombre_contacto, $telefono, $activo, $id);
        $stmt->execute();

        echo json_encode(['success' => true]);
    }

    public function update($params) {
        $id = $params[2] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'ID de proveedor no proporcionado.']);
            return;
        }
        $proveedor = new \app\models\Proveedor();
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $nombre_empresa = $data['nombre_empresa'] ?? '';
        $nombre_contacto = $data['nombre_contacto'] ?? '';
        $telefono = $data['telefono'] ?? '';
        $activo = isset($data['activo']) ? $data['activo'] : 1;

        if (empty($nombre_empresa)) {
            echo json_encode(['error' => 'El nombre de la empresa es obligatorio.']);
            return;
        }

        $proveedor->connect();
        $sql = "UPDATE proveedores SET nombre_empresa=?, nombre_contacto=?, telefono=?, activo=? WHERE id_proveedor=?";
        $stmt = $proveedor->conex->prepare($sql);
        $stmt->bind_param("ssssi", $nombre_empresa, $nombre_contacto, $telefono, $activo, $id);
        $stmt->execute();

        echo json_encode(['success' => true]);
    }
}