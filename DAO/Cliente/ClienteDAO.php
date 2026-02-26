<?php
/* Se abre el bloque PHP */

/* Se incluye el DAO del módulo Cliente */
require_once __DIR__ . '/../../DAO/Cliente/ClienteDAO.php';

/* Se define el controlador CtrlCliente que hereda del DAO */
class CtrlCliente extends ClienteDAO
{
    /* Constructor */
    public function __construct()
    {
        /* Se llama el constructor del DAO */
        parent::__construct();
    }

    /* Función read: carga la vista del módulo */
    public function read()
    {
        /* Se incluye la vista principal */
        require_once __DIR__ . '/../../View/Cliente/viewCliente.php';
    }

    /* Función data: retorna JSON para DataTables */
    public function data()
    {
        /* Se define header JSON */
        header('Content-Type: application/json; charset=utf-8');

        /* Se inicializa la salida */
        $out = [];

        /* Se define el arreglo data */
        $out['data'] = [];

        /* Se obtiene el listado desde el DAO */
        $rows = $this->getAll();

        /* Se recorre el listado */
        foreach ($rows as $i => $r) {

            /* Se arma el HTML de acciones (botones) */
            $acciones = ''
                . '<button type="button" class="btn btn-sm btn-primary" onclick="clienteEditar(\'' . htmlspecialchars($r['cli_nit']) . '\')">Editar</button> '
                . '<button type="button" class="btn btn-sm btn-danger" onclick="clienteEliminar(\'' . htmlspecialchars($r['cli_nit']) . '\')">Eliminar</button>';

            /* Se asignan los campos que DataTables espera */
            $out['data'][$i]['cli_nit'] = $r['cli_nit'];
            $out['data'][$i]['cli_razon_social'] = $r['cli_razon_social'];
            $out['data'][$i]['cli_dir'] = $r['cli_dir'];
            $out['data'][$i]['cli_tel'] = $r['cli_tel'];
            $out['data'][$i]['cli_correo'] = $r['cli_correo'];
            $out['data'][$i]['cli_nombre_contacto'] = $r['cli_nombre_contacto'];
            $out['data'][$i]['cli_estado'] = $r['cli_estado'];
            $out['data'][$i]['acciones'] = $acciones;
        }

        /* Se imprime el JSON */
        echo json_encode($out);

        /* Se detiene ejecución */
        exit;
    }

    /* Función one: retorna un cliente por NIT (para edición) */
    public function one()
    {
        /* Se define header JSON */
        header('Content-Type: application/json; charset=utf-8');

        /* Se lee el NIT */
        $cli_nit = isset($_POST['cli_nit']) ? trim($_POST['cli_nit']) : '';

        /* Se consulta */
        $row = $this->getByNit($cli_nit);

        /* Se responde */
        echo json_encode($row ? $row : []);

        /* Se finaliza */
        exit;
    }

    /* Función save: inserta o actualiza */
    public function save()
    {
        /* Se define header JSON */
        header('Content-Type: application/json; charset=utf-8');

        /* Se toman campos */
        $cli_nit = isset($_POST['cli_nit']) ? trim($_POST['cli_nit']) : '';
        $cli_razon_social = isset($_POST['cli_razon_social']) ? trim($_POST['cli_razon_social']) : '';
        $cli_dir = isset($_POST['cli_dir']) ? trim($_POST['cli_dir']) : '';
        $cli_tel = isset($_POST['cli_tel']) ? trim($_POST['cli_tel']) : '';
        $cli_correo = isset($_POST['cli_correo']) ? trim($_POST['cli_correo']) : '';
        $cli_nombre_contacto = isset($_POST['cli_nombre_contacto']) ? trim($_POST['cli_nombre_contacto']) : '';
        $cli_estado = isset($_POST['cli_estado']) ? trim($_POST['cli_estado']) : 'Activo';

        /* Validación mínima */
        if ($cli_nit === '' || $cli_razon_social === '') {
            /* Respuesta de error */
            echo json_encode(['ok' => false, 'msg' => 'NIT y Razón social son obligatorios.']);
            /* Se finaliza */
            exit;
        }

        /* Usuario creador (si manejas sesión) */
        $Cli_usu_crea = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'system';

        /* Se valida si existe */
        $existe = $this->getByNit($cli_nit);

        /* Si existe, actualiza */
        if ($existe) {

            /* Se actualiza */
            $ok = $this->update(
                $cli_nit,
                $cli_razon_social,
                $cli_dir,
                $cli_tel,
                $cli_correo,
                $cli_nombre_contacto,
                $cli_estado
            );

            /* Se responde */
            echo json_encode(['ok' => $ok, 'msg' => $ok ? 'Cliente actualizado.' : 'No se pudo actualizar.']);

            /* Se finaliza */
            exit;
        }

        /* Si no existe, inserta */
        $ok = $this->insert(
            $cli_nit,
            $cli_razon_social,
            $cli_dir,
            $cli_tel,
            $cli_correo,
            $cli_nombre_contacto,
            $cli_estado,
            $Cli_usu_crea
        );

        /* Se responde */
        echo json_encode(['ok' => $ok, 'msg' => $ok ? 'Cliente registrado.' : 'No se pudo registrar.']);

        /* Se finaliza */
        exit;
    }

    /* Función del: elimina */
    public function del()
    {
        /* Se define header JSON */
        header('Content-Type: application/json; charset=utf-8');

        /* Se lee el nit */
        $cli_nit = isset($_POST['cli_nit']) ? trim($_POST['cli_nit']) : '';

        /* Validación */
        if ($cli_nit === '') {
            /* Respuesta */
            echo json_encode(['ok' => false, 'msg' => 'NIT inválido.']);
            /* Se finaliza */
            exit;
        }

        /* Se elimina */
        $ok = $this->delete($cli_nit);

        /* Se responde */
        echo json_encode(['ok' => $ok, 'msg' => $ok ? 'Cliente eliminado.' : 'No se pudo eliminar.']);

        /* Se finaliza */
        exit;
    }
}