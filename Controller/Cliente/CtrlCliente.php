<?php
include_once '../DAO/Cliente/ClienteDAO.php';

class CtrlCliente extends ClienteDAO {

    public function read(){
        include_once '../View/Cliente/viewCliente.php';
    }

    public function data(){
        $list = $this->getAll();
        $array = [];

        foreach($list as $key => $row){

            $array['data'][$key]['cli_nit'] = $row['cli_nit'];
            $array['data'][$key]['cli_razon_social'] = $row['cli_razon_social'];
            $array['data'][$key]['cli_dir'] = $row['cli_dir'];
            $array['data'][$key]['cli_tel'] = $row['cli_tel'];
            $array['data'][$key]['cli_correo'] = $row['cli_correo'];
            $array['data'][$key]['cli_nombre_contacto'] = $row['cli_nombre_contacto'];

            // Estado 1/0 -> texto
            $array['data'][$key]['cli_estado'] = ($row['cli_estado'] == 1) ? "Activo" : "Inactivo";

            // botones
            $nit = $row['cli_nit'];
            $array['data'][$key]['acciones'] =
                "<button class='btn btn-sm btn-primary' onclick=\"clienteEditar('$nit')\">Editar</button>
                 <button class='btn btn-sm btn-danger' onclick=\"clienteEliminar('$nit')\">Eliminar</button>";
        }

        echo json_encode($array);
    }
}