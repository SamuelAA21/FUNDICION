<?php
include_once '../DAO/TipoPeligro/TipoPeligroDAO.php';

class CtrlTipoPeligro extends TipoPeligroDAO {

    public function read() {
        include_once '../View/TipoPeligro/viewTipoPeligro.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $list = $this->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($list)) {
            $array['data'][] = [
                'tpel_id' => $row['tpel_id'],
                'tpel_descripcion' => $row['tpel_descripcion'],
                'tpel_especifica' => $row['tpel_especifica'],
                'tpel_estado' => $row['tpel_estado'],
                'acciones' =>
                    "<button class='btn btn-sm btn-primary' onclick=\"tipoPeligroEditar('{$row['tpel_id']}')\">Editar</button> " .
                    "<button class='btn btn-sm btn-danger' onclick=\"tipoPeligroEliminar('{$row['tpel_id']}')\">Eliminar</button>"
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $tpel_id = isset($_POST['tpel_id']) ? (int)$_POST['tpel_id'] : 0;
        $rs = $this->getById($tpel_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function save() {
        header('Content-Type: application/json; charset=utf-8');

        $data = [
            'tpel_id' => $_POST['tpel_id'] ?? '',
            'tpel_id_original' => $_POST['tpel_id_original'] ?? '',
            'tpel_descripcion' => trim($_POST['tpel_descripcion'] ?? ''),
            'tpel_especifica' => trim($_POST['tpel_especifica'] ?? ''),
            'tpel_estado' => trim($_POST['tpel_estado'] ?? '')
        ];

        if ((int)$data['tpel_id'] <= 0 || $data['tpel_descripcion'] === '' || $data['tpel_especifica'] === '' || $data['tpel_estado'] === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $originalId = (int)$data['tpel_id_original'];
        $currentId = (int)$data['tpel_id'];

        if ($originalId > 0) {
            if (!$this->existsById($originalId)) {
                echo json_encode(['ok' => false, 'msg' => 'El tipo de peligro a editar ya no existe']);
                return;
            }

            $this->update($originalId, $data);
            echo json_encode(['ok' => true, 'msg' => 'Tipo de peligro actualizado correctamente']);
            return;
        }

        if ($this->existsById($currentId)) {
            echo json_encode(['ok' => false, 'msg' => 'Ya existe un tipo de peligro con ese ID']);
            return;
        }

        $this->insert($data);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de peligro creado correctamente']);
    }

    public function del() {
        header('Content-Type: application/json; charset=utf-8');
        $tpel_id = isset($_POST['tpel_id']) ? (int)$_POST['tpel_id'] : 0;

        if ($tpel_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->delete($tpel_id);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de peligro eliminado correctamente']);
    }
}
