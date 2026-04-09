<?php
include_once '../DAO/EstadoMateria/EstadoMateriaDAO.php';

class CtrlEstadoMateria extends EstadoMateriaDAO {

    public function read() {
        include_once '../View/EstadoMateria/viewEstadoMateria.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $list = $this->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($list)) {
            $array['data'][] = [
                'ematp_id' => $row['ematp_id'],
                'ematp_descripcion' => $row['ematp_descripcion'],
                'acciones' =>
                    "<button class='btn btn-sm btn-primary' onclick=\"estadoMateriaEditar('{$row['ematp_id']}')\">Editar</button> " .
                    "<button class='btn btn-sm btn-danger' onclick=\"estadoMateriaEliminar('{$row['ematp_id']}')\">Eliminar</button>"
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $ematp_id = isset($_POST['ematp_id']) ? (int)$_POST['ematp_id'] : 0;
        $rs = $this->getById($ematp_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function save() {
        header('Content-Type: application/json; charset=utf-8');

        $data = [
            'ematp_id' => $_POST['ematp_id'] ?? '',
            'ematp_id_original' => $_POST['ematp_id_original'] ?? '',
            'ematp_descripcion' => trim($_POST['ematp_descripcion'] ?? '')
        ];

        if ((int)$data['ematp_id'] <= 0 || $data['ematp_descripcion'] === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $originalId = (int)$data['ematp_id_original'];
        $currentId = (int)$data['ematp_id'];

        if ($originalId > 0) {
            if (!$this->existsById($originalId)) {
                echo json_encode(['ok' => false, 'msg' => 'El estado de materia a editar ya no existe']);
                return;
            }

            $this->update($originalId, $data);
            echo json_encode(['ok' => true, 'msg' => 'Estado de materia actualizado correctamente']);
            return;
        }

        if ($this->existsById($currentId)) {
            echo json_encode(['ok' => false, 'msg' => 'Ya existe un estado de materia con ese ID']);
            return;
        }

        $this->insert($data);
        echo json_encode(['ok' => true, 'msg' => 'Estado de materia creado correctamente']);
    }

    public function del() {
        header('Content-Type: application/json; charset=utf-8');
        $ematp_id = isset($_POST['ematp_id']) ? (int)$_POST['ematp_id'] : 0;

        if ($ematp_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->delete($ematp_id);
        echo json_encode(['ok' => true, 'msg' => 'Estado de materia eliminado correctamente']);
    }
}
