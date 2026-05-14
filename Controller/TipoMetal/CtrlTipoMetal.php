<?php
include_once '../DAO/TipoMetal/TipoMetalDAO.php';

class CtrlTipoMetal
{
    private $dao;

    public function __construct()
    {
        $this->dao = new TipoMetalDAO();
    }

    public function read()
    {
        include_once '../View/TipoMetal/viewTipoMetal.php';
    }

    public function data()
    {
        header('Content-Type: application/json; charset=utf-8');
        $rows = $this->dao->getAll();
        $array = ['data' => []];

        foreach ($rows as $row) {
            $array['data'][] = [
                'tmetal_id' => (int)($row['tmetal_id'] ?? 0),
                'tmetal_descripcion' => $row['tmetal_descripcion'] ?? '',
                'tmetal_estado' => ((string)($row['tmetal_estado'] ?? '0') === '1') ? 'Activo' : 'Inactivo'
            ];
        }

        echo json_encode($array);
    }

    public function one()
    {
        header('Content-Type: application/json; charset=utf-8');
        $tmetal_id = isset($_POST['tmetal_id']) ? (int)$_POST['tmetal_id'] : 0;

        if ($tmetal_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        echo json_encode($this->dao->getById($tmetal_id) ?? []);
    }

    public function postNew()
    {
        header('Content-Type: application/json; charset=utf-8');

        $tmetal_descripcion = trim($_POST['tmetal_descripcion'] ?? '');
        $tmetal_estado = isset($_POST['tmetal_estado']) ? (int)$_POST['tmetal_estado'] : 1;

        if ($tmetal_descripcion === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $this->dao->insertRecord($tmetal_descripcion, $tmetal_estado);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de metal creado correctamente']);
    }

    public function update()
    {
        header('Content-Type: application/json; charset=utf-8');

        $tmetal_id = isset($_POST['tmetal_id']) ? (int)$_POST['tmetal_id'] : 0;
        $tmetal_descripcion = trim($_POST['tmetal_descripcion'] ?? '');
        $tmetal_estado = isset($_POST['tmetal_estado']) ? (int)$_POST['tmetal_estado'] : 1;

        if ($tmetal_id <= 0 || $tmetal_descripcion === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $this->dao->updateRecord($tmetal_id, $tmetal_descripcion, $tmetal_estado);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de metal actualizado correctamente']);
    }

    public function delete()
    {
        header('Content-Type: application/json; charset=utf-8');
        $tmetal_id = isset($_POST['tmetal_id']) ? (int)$_POST['tmetal_id'] : 0;

        if ($tmetal_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->dao->deleteRecord($tmetal_id);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de metal eliminado correctamente']);
    }
}
