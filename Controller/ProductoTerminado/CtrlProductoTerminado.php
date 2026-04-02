<?php
include_once '../DAO/ProductoTerminado/ProductoTerminadoDAO.php';

class CtrlProductoTerminado extends ProductoTerminadoDAO {

    public function read() {
        $tiposMetal = $this->getTiposMetal();
        $presentaciones = $this->getPresentaciones();
        $bodegas = $this->getBodegas();
        include_once '../View/ProductoTerminado/viewProductoTerminado.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $list = $this->getAll();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($list)) {
            $array['data'][] = [
                'pro_id' => $row['pro_id'],
                'pro_nombre' => $row['pro_nombre'],
                'tmetal_descripcion' => $row['tmetal_descripcion'] ?? '',
                'pres_descripcion' => $row['pres_descripcion'] ?? '',
                'bod_descripcion' => $row['bod_descripcion'] ?? '',
                'pro_estado' => $row['pro_estado'],
                'acciones' =>
                    "<button class='btn btn-sm btn-primary' onclick=\"productoTerminadoEditar('{$row['pro_id']}')\">Editar</button> " .
                    "<button class='btn btn-sm btn-danger' onclick=\"productoTerminadoEliminar('{$row['pro_id']}')\">Eliminar</button>"
            ];
        }

        echo json_encode($array);
    }

    public function one() {
        header('Content-Type: application/json; charset=utf-8');
        $pro_id = isset($_POST['pro_id']) ? (int)$_POST['pro_id'] : 0;
        $rs = $this->getById($pro_id);
        $row = mysqli_fetch_assoc($rs);
        echo json_encode($row ?: []);
    }

    public function save() {
        header('Content-Type: application/json; charset=utf-8');

        $data = [
            'pro_id' => $_POST['pro_id'] ?? '',
            'pro_nombre' => trim($_POST['pro_nombre'] ?? ''),
            'tmetal_id' => $_POST['tmetal_id'] ?? '',
            'pres_id' => $_POST['pres_id'] ?? '',
            'bod_id' => $_POST['bod_id'] ?? '',
            'pro_estado' => trim($_POST['pro_estado'] ?? '')
        ];

        if ((int)$data['pro_id'] <= 0 || $data['pro_nombre'] === '' || (int)$data['tmetal_id'] <= 0 || (int)$data['pres_id'] <= 0 || (int)$data['bod_id'] <= 0 || $data['pro_estado'] === '') {
            echo json_encode(['ok' => false, 'msg' => 'Complete los campos obligatorios']);
            return;
        }

        $exists = mysqli_fetch_assoc($this->getById($data['pro_id']));
        if ($exists) {
            $this->update($data['pro_id'], $data);
            echo json_encode(['ok' => true, 'msg' => 'Producto terminado actualizado correctamente']);
            return;
        }

        $this->insert($data);
        echo json_encode(['ok' => true, 'msg' => 'Producto terminado creado correctamente']);
    }

    public function del() {
        header('Content-Type: application/json; charset=utf-8');
        $pro_id = isset($_POST['pro_id']) ? (int)$_POST['pro_id'] : 0;

        if ($pro_id <= 0) {
            echo json_encode(['ok' => false, 'msg' => 'ID invalido']);
            return;
        }

        $this->delete($pro_id);
        echo json_encode(['ok' => true, 'msg' => 'Producto terminado eliminado correctamente']);
    }
}
