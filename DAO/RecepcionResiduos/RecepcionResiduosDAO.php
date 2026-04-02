<?php
include_once '../Lib/Config/conexionSqli.php';

class RecepcionResiduosDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): RecepcionResiduosDAO {
        if (self::$instance == NULL) {
            self::$instance = new RecepcionResiduosDAO();
        }
        return self::$instance;
    }

    private function esc($value) {
        return mysqli_real_escape_string($this->getConnect(), trim((string)$value));
    }

    private function str($value) {
        return "'" . $this->esc($value) . "'";
    }

    private function nullableStr($value) {
        if ($value === null || trim((string)$value) === '') {
            return "NULL";
        }
        return "'" . $this->esc($value) . "'";
    }

    public function getAll() {
        $sql = "SELECT rr.*, c.cli_razon_social, tv.tvehi_descripcion, tm.tmanejo_descripcion
                FROM recepcion_residuos rr
                LEFT JOIN cliente c ON rr.cli_nit = c.cli_nit
                LEFT JOIN tipo_vehiculo tv ON rr.tvehi_id = tv.tvehi_id
                LEFT JOIN tipo_manejo tm ON rr.tmanejo_id = tm.tmanejo_id";
        return $this->execute($sql);
    }

    public function getById($rres_id) {
        $rres_id = (int)$rres_id;
        return $this->execute("SELECT * FROM recepcion_residuos WHERE rres_id = $rres_id");
    }

    public function insert($data) {
        $sql = "INSERT INTO recepcion_residuos (
                    rres_id, rres_fecha_doc, rres_fecha_recepcion, cli_nit, rres_transportador,
                    tvehi_id, rres_placa, rres_recomendaciones, usu_crea, rres_total,
                    tmanejo_id, rres_peligro, rres_codigo_qr, rres_estado, usu_anula,
                    fecha_anula, razon_anula
                ) VALUES (
                    " . (int)$data['rres_id'] . ",
                    " . $this->str($data['rres_fecha_doc']) . ",
                    " . $this->str($data['rres_fecha_recepcion']) . ",
                    " . $this->str($data['cli_nit']) . ",
                    " . $this->str($data['rres_transportador']) . ",
                    " . (int)$data['tvehi_id'] . ",
                    " . $this->str($data['rres_placa']) . ",
                    " . $this->str($data['rres_recomendaciones']) . ",
                    " . $this->str($data['usu_crea']) . ",
                    " . (int)$data['rres_total'] . ",
                    " . (int)$data['tmanejo_id'] . ",
                    " . $this->str($data['rres_peligro']) . ",
                    " . $this->str($data['rres_codigo_qr']) . ",
                    " . $this->str($data['rres_estado']) . ",
                    " . $this->nullableStr($data['usu_anula']) . ",
                    " . $this->nullableStr($data['fecha_anula']) . ",
                    " . $this->nullableStr($data['razon_anula']) . "
                )";
        return $this->execute($sql);
    }

    public function update($rres_id, $data) {
        $rres_id = (int)$rres_id;
        $sql = "UPDATE recepcion_residuos SET
                    rres_fecha_doc = " . $this->str($data['rres_fecha_doc']) . ",
                    rres_fecha_recepcion = " . $this->str($data['rres_fecha_recepcion']) . ",
                    cli_nit = " . $this->str($data['cli_nit']) . ",
                    rres_transportador = " . $this->str($data['rres_transportador']) . ",
                    tvehi_id = " . (int)$data['tvehi_id'] . ",
                    rres_placa = " . $this->str($data['rres_placa']) . ",
                    rres_recomendaciones = " . $this->str($data['rres_recomendaciones']) . ",
                    usu_crea = " . $this->str($data['usu_crea']) . ",
                    rres_total = " . (int)$data['rres_total'] . ",
                    tmanejo_id = " . (int)$data['tmanejo_id'] . ",
                    rres_peligro = " . $this->str($data['rres_peligro']) . ",
                    rres_codigo_qr = " . $this->str($data['rres_codigo_qr']) . ",
                    rres_estado = " . $this->str($data['rres_estado']) . ",
                    usu_anula = " . $this->nullableStr($data['usu_anula']) . ",
                    fecha_anula = " . $this->nullableStr($data['fecha_anula']) . ",
                    razon_anula = " . $this->nullableStr($data['razon_anula']) . "
                WHERE rres_id = $rres_id";
        return $this->execute($sql);
    }

    public function delete($rres_id) {
        $rres_id = (int)$rres_id;
        return $this->execute("DELETE FROM recepcion_residuos WHERE rres_id = $rres_id");
    }

    public function getClientes() {
        return $this->execute("SELECT cli_nit, cli_razon_social FROM cliente ORDER BY cli_razon_social");
    }

    public function getVehiculos() {
        return $this->execute("SELECT tvehi_id, tvehi_descripcion FROM tipo_vehiculo ORDER BY tvehi_descripcion");
    }

    public function getUsuarios() {
        return $this->execute("SELECT usu_cedula, usu_nombres, usu_apellidos FROM usuario ORDER BY usu_nombres, usu_apellidos");
    }

    public function getTiposManejo() {
        return $this->execute("SELECT tmanejo_id, tmanejo_descripcion FROM tipo_manejo ORDER BY tmanejo_descripcion");
    }
}
