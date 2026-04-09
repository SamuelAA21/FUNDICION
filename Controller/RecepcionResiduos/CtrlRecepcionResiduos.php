<?php
include_once '../DAO/RecepcionResiduos/RecepcionResiduosDAO.php';

class CtrlRecepcionResiduos extends RecepcionResiduosDAO {

    public function read() {
        $clientes = $this->getClientes();
        $vehiculos = $this->getVehiculos();
        $usuariosCrea = $this->getUsuarios();
        $usuariosAnula = $this->getUsuarios();
        $tiposManejo = $this->getTiposManejo();
        include_once '../View/RecepcionResiduos/viewRecepcionResiduos.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $list = $this->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($list)) {
            $array['data'][] = [
                'rres_id' => $row['rres_id'],
                'rres_fecha_doc' => $row['rres_fecha_doc'],
                'rres_fecha_recepcion' => $row['rres_fecha_recepcion'],
                'cli_razon_social' => $row['cli_razon_social'] ?? $row['cli_nit'],
                'rres_transportador' => $row['rres_transportador'],
                'tvehi_descripcion' => $row['tvehi_descripcion'] ?? '',
                'rres_placa' => $row['rres_placa'],
                'rres_total' => $row['rres_total'],
                'tmanejo_descripcion' => $row['tmanejo_descripcion'] ?? '',
                'rres_peligro' => $row['rres_peligro'],
                'rres_estado' => $row['rres_estado'],
                'acciones' =>
                    "<button class='btn btn-sm btn-primary' onclick=\"recepcionResiduosEditar('{$row['rres_id']}')\">Editar</button> " .
                    "<button class='btn btn-sm btn-danger' onclick=\"recepcionResiduosEliminar('{$row['rres_id']}')\">Eliminar</button>"
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $rres_id = isset($_POST['rres_id']) ? (int)$_POST['rres_id'] : 0;
        $rs = $this->getById($rres_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function save() {
        header('Content-Type: application/json; charset=utf-8');

        $data = [
            'rres_id' => $_POST['rres_id'] ?? '',
            'rres_id_original' => $_POST['rres_id_original'] ?? '',
            'rres_fecha_doc' => str_replace('T', ' ', trim($_POST['rres_fecha_doc'] ?? '')),
            'rres_fecha_recepcion' => trim($_POST['rres_fecha_recepcion'] ?? ''),
            'cli_nit' => trim($_POST['cli_nit'] ?? ''),
            'rres_transportador' => trim($_POST['rres_transportador'] ?? ''),
            'tvehi_id' => $_POST['tvehi_id'] ?? '',
            'rres_placa' => trim($_POST['rres_placa'] ?? ''),
            'rres_recomendaciones' => trim($_POST['rres_recomendaciones'] ?? ''),
            'usu_crea' => trim($_POST['usu_crea'] ?? ''),
            'rres_total' => $_POST['rres_total'] ?? 0,
            'tmanejo_id' => $_POST['tmanejo_id'] ?? '',
            'rres_peligro' => trim($_POST['rres_peligro'] ?? ''),
            'rres_codigo_qr' => trim($_POST['rres_codigo_qr'] ?? ''),
            'rres_estado' => trim($_POST['rres_estado'] ?? ''),
            'usu_anula' => trim($_POST['usu_anula'] ?? ''),
            'fecha_anula' => str_replace('T', ' ', trim($_POST['fecha_anula'] ?? '')),
            'razon_anula' => trim($_POST['razon_anula'] ?? '')
        ];

        if ((int)$data['rres_id'] <= 0 || $data['rres_fecha_doc'] === '' || $data['rres_fecha_recepcion'] === '' || $data['cli_nit'] === '' || $data['rres_transportador'] === '' || (int)$data['tvehi_id'] <= 0 || $data['rres_placa'] === '' || $data['usu_crea'] === '' || (int)$data['tmanejo_id'] <= 0 || $data['rres_estado'] === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $originalId = (int)$data['rres_id_original'];
        $currentId = (int)$data['rres_id'];

        if ($originalId > 0) {
            if (!$this->existsById($originalId)) {
                echo json_encode(['ok' => false, 'msg' => 'La recepcion a editar ya no existe']);
                return;
            }

            $this->update($originalId, $data);
            echo json_encode(['ok' => true, 'msg' => 'Recepcion de residuos actualizada correctamente']);
            return;
        }

        if ($this->existsById($currentId)) {
            echo json_encode(['ok' => false, 'msg' => 'Ya existe una recepcion de residuos con ese ID']);
            return;
        }

        $this->insert($data);
        echo json_encode(['ok' => true, 'msg' => 'Recepcion de residuos creada correctamente']);
    }

    public function del() {
        header('Content-Type: application/json; charset=utf-8');
        $rres_id = isset($_POST['rres_id']) ? (int)$_POST['rres_id'] : 0;

        if ($rres_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->delete($rres_id);
        echo json_encode(['ok' => true, 'msg' => 'Recepcion de residuos eliminada correctamente']);
    }
}
