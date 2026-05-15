<?php
include_once '../DAO/TipoMetal/TipoMetalDAO.php';

class CtrlTipoMetal {

    private $tipoMetalDAO;

    public function __construct() {
        $this->tipoMetalDAO = TipoMetalDAO::getInstance();
    }

    public function read() {
        include_once '../View/TipoMetal/viewTipoMetal.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $rs = $this->tipoMetalDAO->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($rs)) {
            $array['data'][] = [
                'tmetal_id' => $row['tmetal_id'],
                'tmetal_descripcion' => $row['tmetal_descripcion'],
                'tmetal_estado' => ($row['tmetal_estado'] == 1) ? "Activo" : "Inactivo"
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $tmetal_id = isset($_POST['tmetal_id']) ? (int)$_POST['tmetal_id'] : 0;
        $rs = $this->tipoMetalDAO->getById($tmetal_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function postNew() {
        header('Content-Type: application/json; charset=utf-8');

        $tmetal_descripcion = trim($_POST['tmetal_descripcion'] ?? '');
        $tmetal_estado = trim($_POST['tmetal_estado'] ?? '1');

        if ($tmetal_descripcion === '' || $tmetal_estado === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $this->tipoMetalDAO->insertRecord($tmetal_descripcion, $tmetal_estado);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de metal creado correctamente']);
    }

    public function update() {
        header('Content-Type: application/json; charset=utf-8');

        $tmetal_id = isset($_POST['tmetal_id']) ? (int)$_POST['tmetal_id'] : 0;
        $tmetal_descripcion = trim($_POST['tmetal_descripcion'] ?? '');
        $tmetal_estado = trim($_POST['tmetal_estado'] ?? '1');

        if ($tmetal_id <= 0 || $tmetal_descripcion === '' || $tmetal_estado === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $this->tipoMetalDAO->updateRecord($tmetal_id, $tmetal_descripcion, $tmetal_estado);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de metal actualizado correctamente']);
    }

    public function delete() {
        header('Content-Type: application/json; charset=utf-8');
        $tmetal_id = isset($_POST['tmetal_id']) ? (int)$_POST['tmetal_id'] : 0;

        if ($tmetal_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->tipoMetalDAO->deleteRecord($tmetal_id);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de metal eliminado correctamente']);
    }
}
