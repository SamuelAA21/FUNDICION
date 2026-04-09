<?php
include_once '../DAO/DetalleFundicion/DetalleFundicionDAO.php';

class CtrlDetalleFundicion extends DetalleFundicionDAO {

    public function read() {
        $registrosFundicion = $this->getRegistrosFundicion();
        $materiasPrimas = $this->getMateriasPrimas();
        $clientes = $this->getClientes();
        $productos = $this->getProductosTerminados();
        $hornos = $this->getHornos();
        $combustibles = $this->getCombustibles();
        include_once '../View/DetalleFundicion/viewDetalleFundicion.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $list = $this->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($list)) {
            $array['data'][] = [
                'dfun_id' => $row['dfun_id'],
                'rfun_id' => $row['rfun_id'],
                'mat_descripcion' => $row['mat_descripcion'] ?? $row['mat_codigo'],
                'cli_razon_social' => $row['cli_razon_social'] ?? $row['Cli_mat'],
                'dfun_cantidad' => $row['dfun_cantidad'],
                'pro_nombre' => $row['pro_nombre'] ?? $row['pro_id'],
                'hor_descripcion' => $row['hor_descripcion'] ?? $row['hor_id'],
                'com_descripcion' => $row['com_descripcion'] ?? $row['com_id'],
                'dfun_per_metal' => $row['dfun_per_metal'],
                'dfun_num_docrres' => $row['dfun_num_docrres'],
                'acciones' =>
                    "<button class='btn btn-sm btn-primary' onclick=\"detalleFundicionEditar('{$row['dfun_id']}')\">Editar</button> " .
                    "<button class='btn btn-sm btn-danger' onclick=\"detalleFundicionEliminar('{$row['dfun_id']}')\">Eliminar</button>"
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $dfun_id = isset($_POST['dfun_id']) ? (int)$_POST['dfun_id'] : 0;
        $rs = $this->getById($dfun_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function save() {
        header('Content-Type: application/json; charset=utf-8');

        $data = [
            'dfun_id' => $_POST['dfun_id'] ?? '',
            'dfun_id_original' => $_POST['dfun_id_original'] ?? '',
            'rfun_id' => $_POST['rfun_id'] ?? '',
            'mat_codigo' => $_POST['mat_codigo'] ?? '',
            'Cli_mat' => trim($_POST['Cli_mat'] ?? ''),
            'dfun_cantidad' => $_POST['dfun_cantidad'] ?? 0,
            'pro_id' => $_POST['pro_id'] ?? '',
            'dfun_cantprot' => $_POST['dfun_cantprot'] ?? 0,
            'esc_id' => $_POST['esc_id'] ?? 0,
            'dfun_cantesc' => $_POST['dfun_cantesc'] ?? 0,
            'hor_id' => $_POST['hor_id'] ?? '',
            'com_id' => $_POST['com_id'] ?? '',
            'dfun_cantidad_com' => $_POST['dfun_cantidad_com'] ?? 0,
            'dfun_hinicio' => trim($_POST['dfun_hinicio'] ?? ''),
            'dfun_hfin' => trim($_POST['dfun_hfin'] ?? ''),
            'dfun_per_metal' => $_POST['dfun_per_metal'] ?? 0,
            'dfun_num_docrres' => $_POST['dfun_num_docrres'] ?? 0
        ];

        if ((int)$data['dfun_id'] <= 0 || (int)$data['rfun_id'] <= 0 || (int)$data['mat_codigo'] <= 0 || $data['Cli_mat'] === '' || (int)$data['pro_id'] <= 0 || (int)$data['hor_id'] <= 0 || (int)$data['com_id'] <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $originalId = (int)$data['dfun_id_original'];
        $currentId = (int)$data['dfun_id'];

        if ($originalId > 0) {
            if (!$this->existsById($originalId)) {
                echo json_encode(['ok' => false, 'msg' => 'El detalle de fundicion a editar ya no existe']);
                return;
            }

            $this->update($originalId, $data);
            echo json_encode(['ok' => true, 'msg' => 'Detalle fundicion actualizado correctamente']);
            return;
        }

        if ($this->existsById($currentId)) {
            echo json_encode(['ok' => false, 'msg' => 'Ya existe un detalle de fundicion con ese ID']);
            return;
        }

        $this->insert($data);
        echo json_encode(['ok' => true, 'msg' => 'Detalle fundicion creado correctamente']);
    }

    public function del() {
        header('Content-Type: application/json; charset=utf-8');
        $dfun_id = isset($_POST['dfun_id']) ? (int)$_POST['dfun_id'] : 0;

        if ($dfun_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->delete($dfun_id);
        echo json_encode(['ok' => true, 'msg' => 'Detalle fundicion eliminado correctamente']);
    }
}
