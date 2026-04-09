<?php
include_once '../DAO/TipoManejo/TipoManejoDAO.php';

class CtrlTipoManejo extends TipoManejoDAO {

    public function read() {
        include_once '../View/TipoManejo/viewTipoManejo.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $list = $this->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($list)) {
            $array['data'][] = [
                'tmanejo_id' => $row['tmanejo_id'],
                'tmanejo_descripcion' => $row['tmanejo_descripcion'],
                'tmanejo_estado' => $row['tmanejo_estado'],
                'acciones' =>
                    "<button class='btn btn-sm btn-primary' onclick=\"tipoManejoEditar('{$row['tmanejo_id']}')\">Editar</button> " .
                    "<button class='btn btn-sm btn-danger' onclick=\"tipoManejoEliminar('{$row['tmanejo_id']}')\">Eliminar</button>"
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $tmanejo_id = isset($_POST['tmanejo_id']) ? (int)$_POST['tmanejo_id'] : 0;
        $rs = $this->getById($tmanejo_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function save() {
        header('Content-Type: application/json; charset=utf-8');

        $data = [
            'tmanejo_id' => $_POST['tmanejo_id'] ?? '',
            'tmanejo_id_original' => $_POST['tmanejo_id_original'] ?? '',
            'tmanejo_descripcion' => trim($_POST['tmanejo_descripcion'] ?? ''),
            'tmanejo_estado' => trim($_POST['tmanejo_estado'] ?? '')
        ];

        if ((int)$data['tmanejo_id'] <= 0 || $data['tmanejo_descripcion'] === '' || $data['tmanejo_estado'] === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $originalId = (int)$data['tmanejo_id_original'];
        $currentId = (int)$data['tmanejo_id'];

        if ($originalId > 0) {
            if (!$this->existsById($originalId)) {
                echo json_encode(['ok' => false, 'msg' => 'El tipo de manejo a editar ya no existe']);
                return;
            }

            $this->update($originalId, $data);
            echo json_encode(['ok' => true, 'msg' => 'Tipo de manejo actualizado correctamente']);
            return;
        }

        if ($this->existsById($currentId)) {
            echo json_encode(['ok' => false, 'msg' => 'Ya existe un tipo de manejo con ese ID']);
            return;
        }

        $this->insert($data);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de manejo creado correctamente']);
    }

    public function del() {
        header('Content-Type: application/json; charset=utf-8');
        $tmanejo_id = isset($_POST['tmanejo_id']) ? (int)$_POST['tmanejo_id'] : 0;

        if ($tmanejo_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->delete($tmanejo_id);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de manejo eliminado correctamente']);
    }
}
