<?php
include_once '../DAO/TipoVehiculo/TipoVehiculoDAO.php';

class CtrlTipoVehiculo extends TipoVehiculoDAO {

    public function read() {
        include_once '../View/TipoVehiculo/viewTipoVehiculo.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $list = $this->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($list)) {
            $array['data'][] = [
                'tvehi_id' => $row['tvehi_id'],
                'tvehi_descripcion' => $row['tvehi_descripcion'],
                'acciones' =>
                    "<button class='btn btn-sm btn-primary' onclick=\"tipoVehiculoEditar('{$row['tvehi_id']}')\">Editar</button> " .
                    "<button class='btn btn-sm btn-danger' onclick=\"tipoVehiculoEliminar('{$row['tvehi_id']}')\">Eliminar</button>"
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $tvehi_id = isset($_POST['tvehi_id']) ? (int)$_POST['tvehi_id'] : 0;
        $rs = $this->getById($tvehi_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function save() {
        header('Content-Type: application/json; charset=utf-8');

        $data = [
            'tvehi_id' => $_POST['tvehi_id'] ?? '',
            'tvehi_id_original' => $_POST['tvehi_id_original'] ?? '',
            'tvehi_descripcion' => trim($_POST['tvehi_descripcion'] ?? '')
        ];

        if ((int)$data['tvehi_id'] <= 0 || $data['tvehi_descripcion'] === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $originalId = (int)$data['tvehi_id_original'];
        $currentId = (int)$data['tvehi_id'];

        if ($originalId > 0) {
            if (!$this->existsById($originalId)) {
                echo json_encode(['ok' => false, 'msg' => 'El tipo de vehiculo a editar ya no existe']);
                return;
            }

            $this->update($originalId, $data);
            echo json_encode(['ok' => true, 'msg' => 'Tipo de vehiculo actualizado correctamente']);
            return;
        }

        if ($this->existsById($currentId)) {
            echo json_encode(['ok' => false, 'msg' => 'Ya existe un tipo de vehiculo con ese ID']);
            return;
        }

        $this->insert($data);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de vehiculo creado correctamente']);
    }

    public function del() {
        header('Content-Type: application/json; charset=utf-8');
        $tvehi_id = isset($_POST['tvehi_id']) ? (int)$_POST['tvehi_id'] : 0;

        if ($tvehi_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->delete($tvehi_id);
        echo json_encode(['ok' => true, 'msg' => 'Tipo de vehiculo eliminado correctamente']);
    }
}
