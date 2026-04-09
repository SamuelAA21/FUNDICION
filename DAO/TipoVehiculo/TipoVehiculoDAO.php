<?php
include_once '../Lib/Config/conexionSqli.php';

class TipoVehiculoDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): TipoVehiculoDAO {
        if (self::$instance == NULL) {
            self::$instance = new TipoVehiculoDAO();
        }
        return self::$instance;
    }

    private function esc($value) {
        return mysqli_real_escape_string($this->getConnect(), trim((string)$value));
    }

    private function str($value) {
        return "'" . $this->esc($value) . "'";
    }

    public function getAll() {
        return $this->execute("SELECT * FROM tipo_vehiculo ORDER BY tvehi_id");
    }

    public function getById($tvehi_id) {
        $tvehi_id = (int)$tvehi_id;
        return $this->execute("SELECT * FROM tipo_vehiculo WHERE tvehi_id = $tvehi_id");
    }

    public function existsById($tvehi_id): bool {
        $tvehi_id = (int)$tvehi_id;
        $rs = $this->execute("SELECT 1 FROM tipo_vehiculo WHERE tvehi_id = $tvehi_id LIMIT 1");
        return mysqli_num_rows($rs) > 0;
    }

    public function insert($data) {
        $sql = "INSERT INTO tipo_vehiculo (tvehi_id, tvehi_descripcion)
                VALUES (
                    " . (int)$data['tvehi_id'] . ",
                    " . $this->str($data['tvehi_descripcion']) . "
                )";
        return $this->execute($sql);
    }

    public function update($tvehi_id, $data) {
        $tvehi_id = (int)$tvehi_id;
        $sql = "UPDATE tipo_vehiculo SET
                    tvehi_descripcion = " . $this->str($data['tvehi_descripcion']) . "
                WHERE tvehi_id = $tvehi_id";
        return $this->execute($sql);
    }

    public function delete($tvehi_id) {
        $tvehi_id = (int)$tvehi_id;
        return $this->execute("DELETE FROM tipo_vehiculo WHERE tvehi_id = $tvehi_id");
    }
}
