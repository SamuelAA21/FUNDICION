
<?php
include_once '../DAO/Combustible/CombustibleDAO.php';

class CtrlCombustible extends CombustibleDAO {

    public function read(){
        include_once '../View/Combustible/viewCombustible.php';
    }

    public function data(){
        $list = $this->getAll();
        $array = [];
        $i = 0;

        foreach($list as $row){

            $array['data'][$i]['comb_id'] = $row['comb_id'];
            $array['data'][$i]['comb_descripcion'] = $row['comb_descripcion'];
            $array['data'][$i]['comb_estado'] = ($row['comb_estado'] == 1) ? "Activo" : "Inactivo";

            $id = $row['comb_id'];
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

    public function save(){
        $comb_id = $_POST['comb_id'] ?? '';
        $comb_descripcion = trim($_POST['comb_descripcion'] ?? '');
        $comb_estado = $_POST['comb_estado'] ?? 1;

        if($comb_descripcion === ''){
            echo json_encode(["ok"=>false, "msg"=>"La descripción es obligatoria"]);
            return;
        }

        if($comb_id === '' || (int)$comb_id === 0){
            $this->insert($comb_descripcion, $comb_estado);
            echo json_encode(["ok"=>true, "msg"=>"Combustible creado correctamente"]);
            return;
        }

        $this->update($comb_id, $comb_descripcion, $comb_estado);
        echo json_encode(["ok"=>true, "msg"=>"Combustible actualizado correctamente"]);
    }

    public function del(){
        $comb_id = $_POST['comb_id'] ?? 0;

        if((int)$comb_id <= 0){
            echo json_encode(["ok"=>false, "msg"=>"ID inválido"]);
            return;
        }

        $this->delete($comb_id);
        echo json_encode(["ok"=>true, "msg"=>"Combustible eliminado correctamente"]);
    }
}