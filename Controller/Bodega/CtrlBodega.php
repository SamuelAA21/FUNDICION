<?php
include_once '../DAO/Bodega/BodegaDAO.php';

class CtrlBodega extends BodegaDAO {

    public function read() {
        include_once '../View/Bodega/viewBodega.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $list = $this->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($list)) {
            $array['data'][] = [
                'bod_id' => $row['bod_id'],
                'bod_descripcion' => $row['bod_descripcion'],
                'bod_capacidad' => $row['bod_capacidad'],
                'bod_area' => $row['bod_area'],
                'bod_estado' => $row['bod_estado'],
                'acciones' =>
                    "<button class='btn btn-sm btn-primary' onclick=\"bodegaEditar('{$row['bod_id']}')\">Editar</button> " .
                    "<button class='btn btn-sm btn-danger' onclick=\"bodegaEliminar('{$row['bod_id']}')\">Eliminar</button>"
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $bod_id = isset($_POST['bod_id']) ? (int)$_POST['bod_id'] : 0;
        $rs = $this->getById($bod_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function save() {
        header('Content-Type: application/json; charset=utf-8');

        $data = [
            'bod_id' => $_POST['bod_id'] ?? '',
            'bod_id_original' => $_POST['bod_id_original'] ?? '',
            'bod_descripcion' => trim($_POST['bod_descripcion'] ?? ''),
            'bod_capacidad' => trim($_POST['bod_capacidad'] ?? ''),
            'bod_area' => trim($_POST['bod_area'] ?? ''),
            'bod_estado' => trim($_POST['bod_estado'] ?? '')
        ];

        if ((int)$data['bod_id'] <= 0 || $data['bod_descripcion'] === '' || $data['bod_capacidad'] === '' || $data['bod_area'] === '' || $data['bod_estado'] === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $originalId = (int)$data['bod_id_original'];
        $currentId = (int)$data['bod_id'];

        if ($originalId > 0) {
            if (!$this->existsById($originalId)) {
                echo json_encode(['ok' => false, 'msg' => 'La bodega a editar ya no existe']);
                return;
            }

            $this->update($originalId, $data);
            echo json_encode(['ok' => true, 'msg' => 'Bodega actualizada correctamente']);
            return;
        }

        if ($this->existsById($currentId)) {
            echo json_encode(['ok' => false, 'msg' => 'Ya existe una bodega con ese ID']);
            return;
        }

        $this->insert($data);
        echo json_encode(['ok' => true, 'msg' => 'Bodega creada correctamente']);
    }

    public function del() {
        header('Content-Type: application/json; charset=utf-8');
        $bod_id = isset($_POST['bod_id']) ? (int)$_POST['bod_id'] : 0;

        if ($bod_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->delete($bod_id);
        echo json_encode(['ok' => true, 'msg' => 'Bodega eliminada correctamente']);
    }
}
