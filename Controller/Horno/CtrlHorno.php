<?php
include_once '../DAO/Horno/HornoDAO.php';
include_once '../DAO/Combustible/CombustibleDAO.php';

class CtrlHorno extends HornoDAO {

    public function read(){
        // Cargar lista de combustibles para el select
        $combustibleDAO = CombustibleDAO::getInstance();
        $combustibles = $combustibleDAO->getAll();
        include_once '../View/Horno/viewHorno.php';
    }

    public function data(){
        header('Content-Type: application/json; charset=utf-8');
        $rs = $this->getAll();
        $array = ['data' => []];
        $i = 0;

        while($row = mysqli_fetch_assoc($rs)){
            $hor_id = (int)$row['hor_id'];

            $array['data'][$i]['hor_id'] = $hor_id;
            $array['data'][$i]['hor_descripcion'] = $row['hor_descripcion'];
            $array['data'][$i]['com_descripcion'] = $row['com_descripcion'] ?? 'Sin combustible';
            $array['data'][$i]['hor_estado'] = ($row['hor_estado'] == 1) ? "Activo" : "Inactivo";

            $id = $hor_id;
            $array['data'][$i]['acciones'] =
                "<button class='btn btn-sm btn-primary' onclick=\"hornoEditar('$id')\">Editar</button> " .
                "<button class='btn btn-sm btn-danger' onclick=\"hornoEliminar('$id')\">Eliminar</button>";

            $i++;
        }

        echo json_encode($array);
    }

    public function one(){
        header('Content-Type: application/json; charset=utf-8');
        $hor_id = isset($_POST['hor_id']) ? (int)$_POST['hor_id'] : 0;

        if ($hor_id <= 0) {
            echo json_encode(["ok"=>false, "msg"=>"ID inválido"]);
            return;
        }

        $rs = $this->getById($hor_id);
        $row = mysqli_fetch_assoc($rs);

        if($row){
            echo json_encode($row);
        }else{
            echo json_encode([]);
        }
    }

    public function postNew(){
        header('Content-Type: application/json; charset=utf-8');

        $hor_descripcion = trim($_POST['hor_descripcion'] ?? '');
        $com_id = isset($_POST['com_id']) ? (int)$_POST['com_id'] : 0;
        $hor_estado = isset($_POST['hor_estado']) ? (int)$_POST['hor_estado'] : 1;

        if($hor_descripcion === ''){
            echo json_encode(["ok"=>false, "msg"=>"La descripción es obligatoria"]);
            return;
        }

        if((int)$com_id <= 0){
            echo json_encode(["ok"=>false, "msg"=>"Seleccione un combustible válido"]);
            return;
        }

        $this->insertRecord($hor_descripcion, $com_id, $hor_estado);
        echo json_encode(["ok"=>true, "msg"=>"Horno creado correctamente"]);
    }

    public function update(){
        header('Content-Type: application/json; charset=utf-8');

        $hor_id = isset($_POST['hor_id']) ? (int)$_POST['hor_id'] : 0;
        $hor_descripcion = trim($_POST['hor_descripcion'] ?? '');
        $com_id = isset($_POST['com_id']) ? (int)$_POST['com_id'] : 0;
        $hor_estado = isset($_POST['hor_estado']) ? (int)$_POST['hor_estado'] : 1;

        if($hor_descripcion === '' || $hor_id <= 0){
            echo json_encode(["ok"=>false, "msg"=>"Datos inválidos"]);
            return;
        }

        if((int)$com_id <= 0){
            echo json_encode(["ok"=>false, "msg"=>"Seleccione un combustible válido"]);
            return;
        }

        $this->updateRecord($hor_id, $hor_descripcion, $com_id, $hor_estado);
        echo json_encode(["ok"=>true, "msg"=>"Horno actualizado correctamente"]);
    }

    public function delete(){
        header('Content-Type: application/json; charset=utf-8');

        $hor_id = $_POST['hor_id'] ?? 0;

        if((int)$hor_id <= 0){
            echo json_encode(["ok"=>false, "msg"=>"ID inválido"]);
            return;
        }

        $this->deleteRecord($hor_id);
        echo json_encode(["ok"=>true, "msg"=>"Horno eliminado correctamente"]);
    }
}
