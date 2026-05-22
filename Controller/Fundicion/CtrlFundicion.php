<?php
include_once '../DAO/Fundicion/FundicionDAO.php';

class CtrlFundicion {

    private $fundicionDAO;

    public function __construct() {
        $this->fundicionDAO = new FundicionDAO();
    }

    public function read() {
        $responsables = $this->mapResponsables($this->fetchAll($this->fundicionDAO->getResponsablesList()));
        $materiasPrimas = $this->mapMateriasPrimas($this->fetchAll($this->fundicionDAO->getMateriasPrimasList()));
        $clientes = $this->mapClientes($this->fetchAll($this->fundicionDAO->getClientesList()));
        $productos = $this->mapProductos($this->fetchAll($this->fundicionDAO->getProductosTerminadosList()));
        $hornos = $this->mapHornos($this->fetchAll($this->fundicionDAO->getHornosList()));
        $responsablesOptions = $this->buildSimpleOptionsHtml($responsables);
        $materiasPrimasOptions = $this->buildSimpleOptionsHtml($materiasPrimas);
        $clientesOptions = $this->buildSimpleOptionsHtml($clientes);
        $productosOptions = $this->buildSimpleOptionsHtml($productos);
        $hornosOptions = $this->buildHornosOptionsHtml($hornos);
        $horasOptions = $this->buildHorasOptionsHtml();
        $nextNumero = $this->fundicionDAO->getNextRegistroId();
        $mensaje = $_GET['msg'] ?? '';

        include_once '../View/Fundicion/viewFundicion.php';
    }

    public function data() {
        header('Content-Type: application/json; charset=utf-8');
        $rs = $this->fundicionDAO->getReportList();
        $array = ['data' => []];

        while ($row = mysqli_fetch_assoc($rs)) {
            $responsable = trim((string)($row['responsable_nombre'] ?? ''));

            $array['data'][] = [
                'rfun_id' => (int)($row['rfun_id'] ?? 0),
                'rfun_fecha' => $row['rfun_fecha'] ?? '',
                'responsable' => $responsable !== '' ? $responsable : ($row['usu_responsable'] ?? ''),
                'mat_descripcion' => $row['mat_descripcion'] ?? '',
                'dfun_cantidad' => (float)($row['dfun_cantidad'] ?? 0),
                'cli_razon_social' => $row['cli_razon_social'] ?? '',
                'pro_nombre' => $row['pro_nombre'] ?? '',
                'dfun_cantprot' => (float)($row['dfun_cantprot'] ?? 0),
                'dfun_cantesc' => (float)($row['dfun_cantesc'] ?? 0),
                'hor_descripcion' => $row['hor_descripcion'] ?? '',
                'com_descripcion' => $row['com_descripcion'] ?? '',
                'dfun_cantidad_com' => (float)($row['dfun_cantidad_com'] ?? 0),
                'horario' => trim((string)($row['dfun_hinicio'] ?? '')) . (($row['dfun_hinicio'] ?? '') !== '' || ($row['dfun_hfin'] ?? '') !== '' ? ' - ' : '') . trim((string)($row['dfun_hfin'] ?? '')),
                'dfun_per_metal' => (int)($row['dfun_per_metal'] ?? 0),
                'rfun_observacion' => $row['rfun_observacion'] ?? ''
            ];
        }

        echo json_encode($array);
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

        $com_id = $this->fundicionDAO->getCombustibleIdByHorno($hor_id);
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

        $rfun_id = $this->fundicionDAO->getNextRegistroId();
        $dfun_id = $this->fundicionDAO->getNextDetalleId();

        $this->fundicionDAO->insertRegistroFundicion(
            $rfun_id,
            $rfun_fecha,
            $usu_responsable,
            $rfun_observacion,
            $usu_responsable
        );

        $this->fundicionDAO->insertDetalleFundicion(
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

    private function fetchAll($rs) {
        $rows = [];

        while ($row = mysqli_fetch_assoc($rs)) {
            $rows[] = $row;
        }

        return $rows;
    }

    private function mapResponsables($rows) {
        $items = [];

        foreach ($rows as $row) {
            $nombreCompleto = trim(($row['usu_nombres'] ?? '') . ' ' . ($row['usu_apellidos'] ?? ''));
            $items[] = [
                'value' => $row['usu_login'] ?? '',
                'label' => $nombreCompleto !== '' ? $nombreCompleto : ($row['usu_login'] ?? '')
            ];
        }

        return $items;
    }

    private function mapMateriasPrimas($rows) {
        $items = [];

        foreach ($rows as $row) {
            $items[] = [
                'value' => (int)($row['mat_codigo'] ?? 0),
                'label' => $row['mat_descripcion'] ?? ''
            ];
        }

        return $items;
    }

    private function mapClientes($rows) {
        $items = [];

        foreach ($rows as $row) {
            $items[] = [
                'value' => $row['cli_nit'] ?? '',
                'label' => $row['cli_razon_social'] ?? ''
            ];
        }

        return $items;
    }

    private function mapProductos($rows) {
        $items = [];

        foreach ($rows as $row) {
            $items[] = [
                'value' => (int)($row['pro_id'] ?? 0),
                'label' => $row['pro_nombre'] ?? ''
            ];
        }

        return $items;
    }

    private function mapHornos($rows) {
        $items = [];

        foreach ($rows as $row) {
            $items[] = [
                'value' => (int)($row['hor_id'] ?? 0),
                'label' => $row['hor_descripcion'] ?? '',
                'combustible_id' => (int)($row['com_id'] ?? 0),
                'combustible' => $row['com_descripcion'] ?? ''
            ];
        }

        return $items;
    }

    private function buildSimpleOptionsHtml($items) {
        $html = '';

        foreach ($items as $item) {
            $value = htmlspecialchars((string)($item['value'] ?? ''), ENT_QUOTES, 'UTF-8');
            $label = htmlspecialchars((string)($item['label'] ?? ''), ENT_QUOTES, 'UTF-8');
            $html .= '<option value="' . $value . '">' . $label . '</option>';
        }

        return $html;
    }

    private function buildHornosOptionsHtml($items) {
        $html = '';

        foreach ($items as $item) {
            $value = htmlspecialchars((string)($item['value'] ?? ''), ENT_QUOTES, 'UTF-8');
            $label = htmlspecialchars((string)($item['label'] ?? ''), ENT_QUOTES, 'UTF-8');
            $combustibleId = htmlspecialchars((string)($item['combustible_id'] ?? ''), ENT_QUOTES, 'UTF-8');
            $combustible = htmlspecialchars((string)($item['combustible'] ?? ''), ENT_QUOTES, 'UTF-8');

            $html .= '<option value="' . $value . '" data-combustible-id="' . $combustibleId . '" data-combustible="' . $combustible . '">'
                . $label
                . '</option>';
        }

        return $html;
    }

    private function buildHorasOptionsHtml() {
        $html = '';

        for ($hora = 0; $hora < 24; $hora++) {
            for ($min = 0; $min < 60; $min += 30) {
                $time = str_pad((string)$hora, 2, '0', STR_PAD_LEFT) . ':' . str_pad((string)$min, 2, '0', STR_PAD_LEFT);
                $timeEscaped = htmlspecialchars($time, ENT_QUOTES, 'UTF-8');
                $html .= '<option value="' . $timeEscaped . '">' . $timeEscaped . '</option>';
            }
        }

        return $html;
    }
}
