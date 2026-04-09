<?php
include_once '../DAO/TipoMetal/TipoMetalDAO.php';

class CtrlTipoMetal extends TipoMetalDAO {

    public function read() {
        include_once '../View/TipoMetal/viewTipoMetal.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $list = $this->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($list)) {
            $array['data'][] = [
                'tmetal_id' => $row['tmetal_id'],
                'tmetal_descripcion' => $row['tmetal_descripcion'],
                'tmetal_estado' => $row['tmetal_estado'],
                'acciones' =>
                    "<button class='btn btn-sm btn-primary' onclick=\"tipoMetalEditar('{$row['tmetal_id']}')\">Editar</button> " .
                    "<button class='btn btn-sm btn-danger' onclick=\"tipoMetalEliminar('{$row['tmetal_id']}')\">Eliminar</button>"
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $tmetal_id = isset($_POST['tmetal_id']) ? (int)$_POST['tmetal_id'] : 0;
        $rs = $this->getById($tmetal_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function save() {
        header('Content-Type: application/json; charset=utf-8');

        $data = [
            'tmetal_id' => $_POST['tmetal_id'] ?? '',
            'tmetal_id_original' => $_POST['tmetal_id_original'] ?? '',
            'tmetal_descripcion' => trim($_POST['tmetal_descripcion'] ?? ''),
            'tmetal_estado' => trim($_POST['tmetal_estado'] ?? '')
        ];

        if ((int)$data['tmetal_id'] <= 0 || $data['tmetal_descripcion'] === '' || $data['tmetal_estado'] === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $originalId = (int)$data['tmetal_id_original'];
        $currentId = (int)$data['tmetal_id'];

        if ($originalId > 0) {
            if (!$this->existsById($originalId)) {
                echo json_encode(['ok' => false, 'msg' => 'El tipo de metal a editar ya no existe']);
                return;
            }

            $this->update($originalId, $data);
            echo json_encode(['ok' => true, 'msg' => 'Tipo de metal actualizado correctamente']);
            return;
        }

        if ($this->existsById($currentId)) {
            echo json_encode(['ok' => false, 'msg' => 'Ya existe un tipo de metal con ese ID']);
            return;
        }

        $this->insert($data);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de metal creado correctamente']);
    }

    public function del() {
        header('Content-Type: application/json; charset=utf-8');
        $tmetal_id = isset($_POST['tmetal_id']) ? (int)$_POST['tmetal_id'] : 0;

        if ($tmetal_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->delete($tmetal_id);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de metal eliminado correctamente']);
    }
}
