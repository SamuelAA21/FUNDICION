<?php
include_once '../Lib/Config/conexionSqli.php';

class PresentacionDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): PresentacionDAO {
        if (self::$instance == NULL) {
            self::$instance = new PresentacionDAO();
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
        return $this->execute("SELECT * FROM presentacion ORDER BY pres_id");
    }

    public function getById($pres_id) {
        $pres_id = (int)$pres_id;
        return $this->execute("SELECT * FROM presentacion WHERE pres_id = $pres_id");
    }

    public function existsById($pres_id): bool {
        $pres_id = (int)$pres_id;
        $rs = $this->execute("SELECT 1 FROM presentacion WHERE pres_id = $pres_id LIMIT 1");
        return mysqli_num_rows($rs) > 0;
    }

    public function insert($data) {
        $sql = "INSERT INTO presentacion (pres_id, pres_descripcion, pres_estado)
                VALUES (
                    " . (int)$data['pres_id'] . ",
                    " . $this->str($data['pres_descripcion']) . ",
                    " . $this->str($data['pres_estado']) . "
                )";
        return $this->execute($sql);
    }

    public function update($pres_id, $data) {
        $pres_id = (int)$pres_id;
        $sql = "UPDATE presentacion SET
                    pres_descripcion = " . $this->str($data['pres_descripcion']) . ",
                    pres_estado = " . $this->str($data['pres_estado']) . "
                WHERE pres_id = $pres_id";
        return $this->execute($sql);
    }

    public function delete($pres_id) {
        $pres_id = (int)$pres_id;
        return $this->execute("DELETE FROM presentacion WHERE pres_id = $pres_id");
    }
}
