<?php
include_once '../Lib/Config/conexionSqli.php';

class BodegaDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): BodegaDAO {
        if (self::$instance == NULL) {
            self::$instance = new BodegaDAO();
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
        return $this->execute("SELECT * FROM bodega ORDER BY bod_id");
    }

    public function getById($bod_id) {
        $bod_id = (int)$bod_id;
        return $this->execute("SELECT * FROM bodega WHERE bod_id = $bod_id");
    }

    public function existsById($bod_id): bool {
        $bod_id = (int)$bod_id;
        $rs = $this->execute("SELECT 1 FROM bodega WHERE bod_id = $bod_id LIMIT 1");
        return mysqli_num_rows($rs) > 0;
    }

    public function insertRecord($data) {
        $sql = "INSERT INTO bodega (bod_id, bod_descripcion, bod_capacidad, bod_area, bod_estado)
                VALUES (
                    " . (int)$data['bod_id'] . ",
                    " . $this->str($data['bod_descripcion']) . ",
                    " . $this->str($data['bod_capacidad']) . ",
                    " . $this->str($data['bod_area']) . ",
                    " . $this->str($data['bod_estado']) . "
                )";
        return $this->execute($sql);
    }

    public function updateRecord($bod_id, $data) {
        $bod_id = (int)$bod_id;
        $sql = "UPDATE bodega SET
                    bod_descripcion = " . $this->str($data['bod_descripcion']) . ",
                    bod_capacidad = " . $this->str($data['bod_capacidad']) . ",
                    bod_area = " . $this->str($data['bod_area']) . ",
                    bod_estado = " . $this->str($data['bod_estado']) . "
                WHERE bod_id = $bod_id";
        return $this->execute($sql);
    }

    public function deleteRecord($bod_id) {
        $bod_id = (int)$bod_id;
        return $this->execute("DELETE FROM bodega WHERE bod_id = $bod_id");
    }
}
