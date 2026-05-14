<?php
include_once '../DAO/Fundicion/FundicionDAO.php';

class CtrlFundicion extends FundicionDAO {

    public function read() {
        $responsables = $this->getResponsablesList();
        $materiasPrimas = $this->getMateriasPrimasList();
        $clientes = $this->getClientesList();
        $productos = $this->getProductosTerminadosList();
        $hornos = $this->getHornosList();
        $nextNumero = $this->getNextRegistroId();
        $mensaje = $_GET['msg'] ?? '';

        include_once '../View/Fundicion/viewFundicion.php';
    }

    public function postNew() {
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

        $com_id = $this->getCombustibleIdByHorno($hor_id);
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

        $rfun_id = $this->getNextRegistroId();
        $dfun_id = $this->getNextDetalleId();

        $this->insertRegistroFundicion(
            $rfun_id,
            $rfun_fecha,
            $usu_responsable,
            $rfun_observacion,
            $usu_responsable
        );

        $this->insertDetalleFundicion(
            $dfun_id,
            $rfun_id,
            $mat_codigo,
            $cli_mat,
            $dfun_cantidad,
            $pro_id,
            $dfun_cantprot,
            0,
            $dfun_cantesc,
            $hor_id,
            $com_id,
            $dfun_cantidad_com,
            $dfun_hinicio,
            $dfun_hfin,
            $dfun_per_metal,
            0
        );

        redirect(getUrl('Fundicion', 'Fundicion', 'read', ['msg' => 'guardado']));
    }
}
