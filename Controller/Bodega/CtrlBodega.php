<?php
include_once '../DAO/Bodega/BodegaDAO.php';

class CtrlBodega
{
    private $dao;

    public function __construct()
    {
        $this->dao = new BodegaDAO();
    }

    public function read()
    {
        include_once '../View/Bodega/viewBodega.php';
    }

    public function data()
    {
        header('Content-Type: application/json; charset=utf-8');
        $rows = $this->dao->getAll();
        $array = ['data' => []];

        foreach ($rows as $row) {
            $bod_id = (int)($row['bod_id'] ?? 0);

            $array['data'][] = [
                'bod_id' => $bod_id,
                'bod_descripcion' => $row['bod_descripcion'] ?? '',
                'bod_capacidad' => $row['bod_capacidad'] ?? '',
                'bod_area' => $row['bod_area'] ?? '',
                'bod_estado' => $row['bod_estado'] ?? 'Inactivo',
                'acciones' => '<button class="btn btn-sm btn-primary btn-edit" data-id="' . $bod_id . '">Editar</button> '
                    . '<button class="btn btn-sm btn-danger btn-delete" data-id="' . $bod_id . '">Eliminar</button>'
            ];
        }

        echo json_encode($array);
    }

    public function one()
    {
        header('Content-Type: application/json; charset=utf-8');
        $bod_id = isset($_POST['bod_id']) ? (int)$_POST['bod_id'] : 0;

        if ($bod_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        echo json_encode($this->dao->getById($bod_id) ?? []);
    }

    public function postNew()
    {
        header('Content-Type: application/json; charset=utf-8');
        $data = $this->collectData();

        if ($data['error'] !== null) {
            echo json_encode(['ok' => false, 'msg' => $data['error']]);
            return;
        }

        $this->dao->insertRecord($data['payload']);
        echo json_encode(['ok' => true, 'msg' => 'Bodega creada correctamente']);
    }

    public function update()
    {
        header('Content-Type: application/json; charset=utf-8');
        $bod_id = isset($_POST['bod_id']) ? (int)$_POST['bod_id'] : 0;
        $data = $this->collectData();

        if ($bod_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        if ($data['error'] !== null) {
            echo json_encode(['ok' => false, 'msg' => $data['error']]);
            return;
        }

        $this->dao->updateRecord($bod_id, $data['payload']);
        echo json_encode(['ok' => true, 'msg' => 'Bodega actualizada correctamente']);
    }

    public function delete()
    {
        header('Content-Type: application/json; charset=utf-8');
        $bod_id = isset($_POST['bod_id']) ? (int)$_POST['bod_id'] : 0;

        if ($bod_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->dao->deleteRecord($bod_id);
        echo json_encode(['ok' => true, 'msg' => 'Bodega eliminada correctamente']);
    }

    private function collectData(): array
    {
        $payload = [
            'bod_id' => isset($_POST['bod_id']) ? (int)$_POST['bod_id'] : 0,
            'bod_descripcion' => trim($_POST['bod_descripcion'] ?? ''),
            'bod_capacidad' => trim($_POST['bod_capacidad'] ?? ''),
            'bod_area' => trim($_POST['bod_area'] ?? ''),
            'bod_estado' => trim($_POST['bod_estado'] ?? 'Activo')
        ];

        if ($payload['bod_id'] <= 0) {
            return ['error' => 'El ID es obligatorio', 'payload' => $payload];
        }

        if ($payload['bod_descripcion'] === '' || $payload['bod_capacidad'] === '' || $payload['bod_area'] === '') {
            return ['error' => 'Complete los campos obligatorios', 'payload' => $payload];
        }

        if ($payload['bod_estado'] !== 'Activo' && $payload['bod_estado'] !== 'Inactivo') {
            return ['error' => 'Estado invalido', 'payload' => $payload];
        }

        return ['error' => null, 'payload' => $payload];
    }
}
