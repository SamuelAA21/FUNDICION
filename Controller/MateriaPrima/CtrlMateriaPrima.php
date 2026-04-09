<?php
include_once '../DAO/MateriaPrima/MateriaPrimaDAO.php';

class CtrlMateriaPrima extends MateriaPrimaDAO {

    public function read() {
        $tiposMetal = $this->getTiposMetal();
        $estadosMateria = $this->getEstadosMateria();
        $presentaciones = $this->getPresentaciones();
        $bodegas = $this->getBodegas();
        $tiposPeligro = $this->getTiposPeligro();
        $productos = $this->getProductosTerminados();
        include_once '../View/MateriaPrima/viewMateriaPrima.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $list = $this->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($list)) {
            $array['data'][] = [
                'mat_codigo' => $row['mat_codigo'],
                'mat_descripcion' => $row['mat_descripcion'],
                'mat_peligrosidad' => $row['mat_peligrosidad'],
                'tmetal_descripcion' => $row['tmetal_descripcion'] ?? '',
                'ematp_descripcion' => $row['ematp_descripcion'] ?? '',
                'pres_descripcion' => $row['pres_descripcion'] ?? '',
                'corr_id' => $row['corr_id'],
                'bod_descripcion' => $row['bod_descripcion'] ?? '',
                'tpel_descripcion' => $row['tpel_descripcion'] ?? '',
                'pro_nombre' => $row['pro_nombre'] ?? '',
                'mat_estado' => $row['mat_estado'],
                'acciones' =>
                    "<button class='btn btn-sm btn-primary' onclick=\"materiaPrimaEditar('{$row['mat_codigo']}')\">Editar</button> " .
                    "<button class='btn btn-sm btn-danger' onclick=\"materiaPrimaEliminar('{$row['mat_codigo']}')\">Eliminar</button>"
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $mat_codigo = isset($_POST['mat_codigo']) ? (int)$_POST['mat_codigo'] : 0;
        $rs = $this->getById($mat_codigo);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function save() {
        header('Content-Type: application/json; charset=utf-8');

        $data = [
            'mat_codigo' => $_POST['mat_codigo'] ?? '',
            'mat_codigo_original' => $_POST['mat_codigo_original'] ?? '',
            'mat_descripcion' => $_POST['mat_descripcion'] ?? '',
            'mat_peligrosidad' => $_POST['mat_peligrosidad'] ?? '',
            'tmetal_id' => $_POST['tmetal_id'] ?? '',
            'ematp_id' => $_POST['ematp_id'] ?? '',
            'pres_id' => $_POST['pres_id'] ?? '',
            'corr_id' => $_POST['corr_id'] ?? '',
            'bod_id' => $_POST['bod_id'] ?? '',
            'tpel_id' => $_POST['tpel_id'] ?? '',
            'pro_id' => $_POST['pro_id'] ?? '',
            'mat_estado' => trim($_POST['mat_estado'] ?? '')
        ];

        if ((int)$data['mat_codigo'] <= 0 || trim((string)$data['mat_peligrosidad']) === '' || (int)$data['tmetal_id'] <= 0 || (int)$data['ematp_id'] <= 0 || (int)$data['pres_id'] <= 0 || (int)$data['bod_id'] <= 0 || (int)$data['pro_id'] <= 0 || $data['mat_estado'] === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $originalId = (int)$data['mat_codigo_original'];
        $currentId = (int)$data['mat_codigo'];

        if ($originalId > 0) {
            if (!$this->existsById($originalId)) {
                echo json_encode(['ok' => false, 'msg' => 'La materia prima a editar ya no existe']);
                return;
            }

            $this->update($originalId, $data);
            echo json_encode(['ok' => true, 'msg' => 'Materia prima actualizada correctamente']);
            return;
        }

        if ($this->existsById($currentId)) {
            echo json_encode(['ok' => false, 'msg' => 'Ya existe una materia prima con ese codigo']);
            return;
        }

        $this->insert($data);
        echo json_encode(['ok' => true, 'msg' => 'Materia prima creada correctamente']);
    }

    public function del() {
        header('Content-Type: application/json; charset=utf-8');
        $mat_codigo = isset($_POST['mat_codigo']) ? (int)$_POST['mat_codigo'] : 0;

        if ($mat_codigo <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->delete($mat_codigo);
        echo json_encode(['ok' => true, 'msg' => 'Materia prima eliminada correctamente']);
    }
}
