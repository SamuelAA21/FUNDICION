<?php
include_once '../DAO/Horno/HornoDAO.php';
include_once '../DAO/Combustible/CombustibleDAO.php';

class CtrlHorno {

    private $hornoDAO;

    public function __construct() {
        $this->hornoDAO = HornoDAO::getInstance();
    }

    public function read() {
        $combustibleDAO = CombustibleDAO::getInstance();
        $rsCombustibles = $combustibleDAO->getAll();
        $combustibles = [];

        while ($row = mysqli_fetch_assoc($rsCombustibles)) {
            $combustibles[] = [
                'id' => (int)($row['com_id'] ?? 0),
                'descripcion' => trim((string)($row['com_descripcion'] ?? ''))
            ];
        }

        include_once '../View/Horno/viewHorno.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $rs = $this->hornoDAO->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($rs)) {
            $hor_id = (int)$row['hor_id'];
            $estadoRaw = trim((string)($row['hor_estado'] ?? '0'));
            $estado = ($estadoRaw === '1' || strcasecmp($estadoRaw, 'activo') === 0) ? 'Activo' : 'Inactivo';

            $array['data'][] = [
                'hor_id' => $hor_id,
                'hor_descripcion' => $row['hor_descripcion'],
                'com_descripcion' => $row['com_descripcion'] ?? 'Sin combustible',
                'hor_estado' => $estado,
                'acciones' => '<button class="btn btn-sm btn-primary btn-edit" data-id="' . $hor_id . '">Editar</button> '
                    . '<button class="btn btn-sm btn-danger btn-delete" data-id="' . $hor_id . '">Eliminar</button>'
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $hor_id = isset($_POST['hor_id']) ? (int)$_POST['hor_id'] : 0;

        if ($hor_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $rs = $this->hornoDAO->getById($hor_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function postNew() {
        header('Content-Type: application/json; charset=utf-8');

        $hor_descripcion = trim($_POST['hor_descripcion'] ?? '');
        $com_id = isset($_POST['com_id']) ? (int)$_POST['com_id'] : 0;
        $hor_estado = isset($_POST['hor_estado']) ? (int)$_POST['hor_estado'] : 1;

        if ($hor_descripcion === '') {
            echo json_encode(['ok' => false, 'msg' => 'La descripcion es obligatoria']);
            return;
        }

        if ($com_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'Seleccione un combustible valido']);
            return;
        }

        $this->hornoDAO->insertRecord($hor_descripcion, $com_id, $hor_estado);
        echo json_encode(['ok' => true, 'msg' => 'Horno creado correctamente']);
    }

    public function update() {
        header('Content-Type: application/json; charset=utf-8');

        $hor_id = isset($_POST['hor_id']) ? (int)$_POST['hor_id'] : 0;
        $hor_descripcion = trim($_POST['hor_descripcion'] ?? '');
        $com_id = isset($_POST['com_id']) ? (int)$_POST['com_id'] : 0;
        $hor_estado = isset($_POST['hor_estado']) ? (int)$_POST['hor_estado'] : 1;

        if ($hor_id <= 0 || $hor_descripcion === '') {
            echo json_encode(['ok' => false, 'msg' => 'Datos invalidos']);
            return;
        }

        if ($com_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'Seleccione un combustible valido']);
            return;
        }

        $this->hornoDAO->updateRecord($hor_id, $hor_descripcion, $com_id, $hor_estado);
        echo json_encode(['ok' => true, 'msg' => 'Horno actualizado correctamente']);
    }

    public function delete() {
        header('Content-Type: application/json; charset=utf-8');
        $hor_id = isset($_POST['hor_id']) ? (int)$_POST['hor_id'] : 0;

        if ($hor_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->hornoDAO->deleteRecord($hor_id);
        echo json_encode(['ok' => true, 'msg' => 'Horno eliminado correctamente']);
    }
}
