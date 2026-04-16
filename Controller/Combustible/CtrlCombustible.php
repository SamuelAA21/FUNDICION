
<?php
include_once '../DAO/Combustible/CombustibleDAO.php';

class CtrlCombustible extends CombustibleDAO {

    public function read(){
        include_once '../View/Combustible/viewCombustible.php';
    }

    public function data(){
        $rs = $this->getAll();
        $array = ['data' => []];
        $i = 0;

        while($row = mysqli_fetch_assoc($rs)){
            $array['data'][$i]['comb_id'] = $row['com_id'];
            $array['data'][$i]['comb_descripcion'] = $row['com_descripcion'];
            $array['data'][$i]['comb_estado'] = ($row['com_estado'] == 1) ? "Activo" : "Inactivo";

            $id = $array['data'][$i]['comb_id'];
            $array['data'][$i]['acciones'] =
                "<button class='btn btn-sm btn-primary' onclick=\"combustibleEditar('$id')\">Editar</button>
                 <button class='btn btn-sm btn-danger' onclick=\"combustibleEliminar('$id')\">Eliminar</button>";

            $i++;
        }

        echo json_encode($array);
    }

    public function one(){
        $comb_id = $_POST['comb_id'] ?? 0;

        $rs = $this->getById($comb_id);
        $row = mysqli_fetch_assoc($rs);

        if($row){
            echo json_encode($row);
        }else{
            echo json_encode([]);
        }
    }

    public function postNew(){
        $comb_descripcion = trim($_POST['comb_descripcion'] ?? '');
        $comb_estado = $_POST['comb_estado'] ?? 1;

        if($comb_descripcion === ''){
            echo json_encode(["ok"=>false, "msg"=>"La descripción es obligatoria"]);
            return;
        }

        $this->insertRecordRecord($comb_descripcion, $comb_estado);
        echo json_encode(["ok"=>true, "msg"=>"Combustible creado correctamente"]);
    }

    public function update(){
        $comb_id = $_POST['comb_id'] ?? 0;
        $comb_descripcion = trim($_POST['comb_descripcion'] ?? '');
        $comb_estado = $_POST['comb_estado'] ?? 1;

        if($comb_descripcion === '' || (int)$comb_id <= 0){
            echo json_encode(["ok"=>false, "msg"=>"Datos inválidos"]);
            return;
        }

        $this->updateRecord($comb_id, $comb_descripcion, $comb_estado);
        echo json_encode(["ok"=>true, "msg"=>"Combustible actualizado correctamente"]);
    }

    public function delete(){
        $comb_id = $_POST['comb_id'] ?? 0;

        if((int)$comb_id <= 0){
            echo json_encode(["ok"=>false, "msg"=>"ID inválido"]);
            return;
        }

        $this->deleteRecord($comb_id);
        echo json_encode(["ok"=>true, "msg"=>"Combustible eliminado correctamente"]);
    }
}