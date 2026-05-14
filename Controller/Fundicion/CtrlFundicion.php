<?php
include_once '../DAO/Fundicion/FundicionDAO.php';

class CtrlFundicion
{
    private $dao;

    public function __construct()
    {
        $this->dao = new FundicionDAO();
    }

    public function read()
    {
        $responsables = $this->dao->getResponsablesList();
        $materiasPrimas = $this->dao->getMateriasPrimasList();
        $clientes = $this->dao->getClientesList();
        $productos = $this->dao->getProductosTerminadosList();
        $hornos = $this->dao->getHornosList();
        $nextNumero = $this->dao->getNextRegistroId();
        $mensaje = $_GET['msg'] ?? '';

        include_once '../View/Fundicion/viewFundicion.php';
    }

    public function postNew()
    {
        $rfun_fecha = trim($_POST['fun_fecha'] ?? '');
        $usu_responsable = trim($_POST['fun_responsable'] ?? '');
        $mat_codigo = isset($_POST['fun_mat_codigo']) ? (int)$_POST['fun_mat_codigo'] : 0;
        $cli_mat = trim($_POST['fun_cliente_id'] ?? '');
        $dfun_cantidad = isset($_POST['fun_materia_cantidad']) ? (float)$_POST['fun_materia_cantidad'] : 0;
        $pro_id = isset($_POST['fun_producto_id']) ? (int)$_POST['fun_producto_id'] : 0;
        $dfun_cantprot = isset($_POST['fun_producto_cantidad']) ? (float)$_POST['fun_producto_cantidad'] : 0;
        $residuo_texto = trim($_POST['fun_residuo'] ?? '');
        $dfun_cantesc = isset($_POST['fun_residuo_cantidad']) ? (float)$_POST['fun_residuo_cantidad'] : 0;
        $hor_id = isset($_POST['fun_horno']) ? (int)$_POST['fun_horno'] : 0;
        $dfun_cantidad_com = isset($_POST['fun_combustible_cantidad']) ? (float)$_POST['fun_combustible_cantidad'] : 0;
        $dfun_hinicio = trim($_POST['fun_hora_inicio'] ?? '');
        $dfun_hfin = trim($_POST['fun_hora_fin'] ?? '');
        $dfun_per_metal = isset($_POST['fun_perdida_metalica']) ? (int)$_POST['fun_perdida_metalica'] : 0;
        $rfun_observacion = trim($_POST['fun_observaciones'] ?? '');

        if ($rfun_fecha === '' || $usu_responsable === '' || $mat_codigo <= 0 || $cli_mat === '' || $pro_id <= 0 || $hor_id <= 0) {
            messageSweetAlert(
                'Datos incompletos',
                'Complete los campos obligatorios del registro de fundicion.',
                'error',
                '#dc3545',
                getUrl('Fundicion', 'Fundicion', 'read')
            );
            return;
        }

        if ($dfun_cantidad <= 0 || $dfun_cantprot < 0 || $dfun_cantidad_com < 0) {
            messageSweetAlert(
                'Datos invalidos',
                'Las cantidades deben ser validas y mayores o iguales a cero.',
                'error',
                '#dc3545',
                getUrl('Fundicion', 'Fundicion', 'read')
            );
            return;
        }

        if ($dfun_hinicio !== '' && $dfun_hfin !== '' && strcmp($dfun_hfin, $dfun_hinicio) < 0) {
            messageSweetAlert(
                'Horario invalido',
                'La hora fin no puede ser menor que la hora inicio.',
                'error',
                '#dc3545',
                getUrl('Fundicion', 'Fundicion', 'read')
            );
            return;
        }

        $com_id = $this->dao->getCombustibleIdByHorno($hor_id);
        if ($com_id <= 0) {
            messageSweetAlert(
                'Horno invalido',
                'El horno seleccionado no tiene combustible asociado.',
                'error',
                '#dc3545',
                getUrl('Fundicion', 'Fundicion', 'read')
            );
            return;
        }

        if ($residuo_texto !== '') {
            $rfun_observacion = trim($rfun_observacion . "\nResiduo: " . $residuo_texto);
        }

        $rfun_id = $this->dao->getNextRegistroId();
        $dfun_id = $this->dao->getNextDetalleId();

        $ok = $this->dao->saveFundicion(
            [
                'rfun_id' => $rfun_id,
                'rfun_fecha' => $rfun_fecha,
                'usu_responsable' => $usu_responsable,
                'rfun_observacion' => $rfun_observacion,
                'usu_crea' => $usu_responsable
            ],
            [
                'dfun_id' => $dfun_id,
                'rfun_id' => $rfun_id,
                'mat_codigo' => $mat_codigo,
                'cli_mat' => $cli_mat,
                'dfun_cantidad' => $dfun_cantidad,
                'pro_id' => $pro_id,
                'dfun_cantprot' => $dfun_cantprot,
                'esc_id' => 0,
                'dfun_cantesc' => $dfun_cantesc,
                'hor_id' => $hor_id,
                'com_id' => $com_id,
                'dfun_cantidad_com' => $dfun_cantidad_com,
                'dfun_hinicio' => $dfun_hinicio,
                'dfun_hfin' => $dfun_hfin,
                'dfun_per_metal' => $dfun_per_metal,
                'dfun_num_docrres' => 0
            ]
        );

        if (!$ok) {
            messageSweetAlert(
                'Error al guardar',
                'No fue posible registrar la fundicion.',
                'error',
                '#dc3545',
                getUrl('Fundicion', 'Fundicion', 'read')
            );
            return;
        }

        redirect(getUrl('Fundicion', 'Fundicion', 'read', ['msg' => 'guardado']));
    }
}
