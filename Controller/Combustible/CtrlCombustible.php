<?php
include_once '../DAO/Combustible/CombustibleDAO.php';

class CtrlCombustible extends CombustibleDAO {

    public function read() {
        include_once '../View/Combustible/viewCombustible.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $rs = $this->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($rs)) {
            $comb_id = (int)($row['com_id'] ?? 0);
            $estadoRaw = trim((string)($row['com_estado'] ?? '0'));
            $estado = ($estadoRaw === '1' || strcasecmp($estadoRaw, 'activo') === 0) ? 'Activo' : 'Inactivo';

            $array['data'][] = [
                'comb_id' => $comb_id,
                'comb_descripcion' => $row['com_descripcion'] ?? '',
                'comb_estado' => $estado,
                'acciones' => '<button class="btn btn-sm btn-primary btn-edit" data-id="' . $comb_id . '">Editar</button> '
                    . '<button class="btn btn-sm btn-danger btn-delete" data-id="' . $comb_id . '">Eliminar</button>'
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $comb_id = isset($_POST['comb_id']) ? (int)$_POST['comb_id'] : 0;

        if ($comb_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $rs = $this->getById($comb_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function postNew() {
        header('Content-Type: application/json; charset=utf-8');
        $comb_descripcion = trim($_POST['comb_descripcion'] ?? '');
        $comb_estado = isset($_POST['comb_estado']) ? (int)$_POST['comb_estado'] : 1;

        if ($comb_descripcion === '') {
            echo json_encode(['ok' => false, 'msg' => 'La descripcion es obligatoria']);
            return;
        }

        $this->insertRecord($comb_descripcion, $comb_estado);
        echo json_encode(['ok' => true, 'msg' => 'Combustible creado correctamente']);
    }

    public function update() {
        header('Content-Type: application/json; charset=utf-8');
        $comb_id = isset($_POST['comb_id']) ? (int)$_POST['comb_id'] : 0;
        $comb_descripcion = trim($_POST['comb_descripcion'] ?? '');
        $comb_estado = isset($_POST['comb_estado']) ? (int)$_POST['comb_estado'] : 1;

        if ($comb_id <= 0 || $comb_descripcion === '') {
            echo json_encode(['ok' => false, 'msg' => 'Datos invalidos']);
            return;
        }

        $this->updateRecord($comb_id, $comb_descripcion, $comb_estado);
        echo json_encode(['ok' => true, 'msg' => 'Combustible actualizado correctamente']);
    }

    public function delete() {
        header('Content-Type: application/json; charset=utf-8');
        $comb_id = isset($_POST['comb_id']) ? (int)$_POST['comb_id'] : 0;

        if ($comb_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->deleteRecord($comb_id);
        echo json_encode(['ok' => true, 'msg' => 'Combustible eliminado correctamente']);
    }
}
