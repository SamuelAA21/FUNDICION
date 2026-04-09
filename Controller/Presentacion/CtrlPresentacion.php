<?php
include_once '../DAO/Presentacion/PresentacionDAO.php';

class CtrlPresentacion extends PresentacionDAO {

    public function read() {
        include_once '../View/Presentacion/viewPresentacion.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $list = $this->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($list)) {
            $array['data'][] = [
                'pres_id' => $row['pres_id'],
                'pres_descripcion' => $row['pres_descripcion'],
                'pres_estado' => $row['pres_estado'],
                'acciones' =>
                    "<button class='btn btn-sm btn-primary' onclick=\"presentacionEditar('{$row['pres_id']}')\">Editar</button> " .
                    "<button class='btn btn-sm btn-danger' onclick=\"presentacionEliminar('{$row['pres_id']}')\">Eliminar</button>"
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $pres_id = isset($_POST['pres_id']) ? (int)$_POST['pres_id'] : 0;
        $rs = $this->getById($pres_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function save() {
        header('Content-Type: application/json; charset=utf-8');

        $data = [
            'pres_id' => $_POST['pres_id'] ?? '',
            'pres_id_original' => $_POST['pres_id_original'] ?? '',
            'pres_descripcion' => trim($_POST['pres_descripcion'] ?? ''),
            'pres_estado' => trim($_POST['pres_estado'] ?? '')
        ];

        if ((int)$data['pres_id'] <= 0 || $data['pres_descripcion'] === '' || $data['pres_estado'] === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $originalId = (int)$data['pres_id_original'];
        $currentId = (int)$data['pres_id'];

        if ($originalId > 0) {
            if (!$this->existsById($originalId)) {
                echo json_encode(['ok' => false, 'msg' => 'La presentacion a editar ya no existe']);
                return;
            }

            $this->update($originalId, $data);
            echo json_encode(['ok' => true, 'msg' => 'Presentacion actualizada correctamente']);
            return;
        }

        if ($this->existsById($currentId)) {
            echo json_encode(['ok' => false, 'msg' => 'Ya existe una presentacion con ese ID']);
            return;
        }

        $this->insert($data);
        echo json_encode(['ok' => true, 'msg' => 'Presentacion creada correctamente']);
    }

    public function del() {
        header('Content-Type: application/json; charset=utf-8');
        $pres_id = isset($_POST['pres_id']) ? (int)$_POST['pres_id'] : 0;

        if ($pres_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->delete($pres_id);
        echo json_encode(['ok' => true, 'msg' => 'Presentacion eliminada correctamente']);
    }
}
