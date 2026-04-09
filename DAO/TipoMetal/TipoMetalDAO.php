<?php
include_once '../Lib/Config/conexionSqli.php';

class TipoMetalDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): TipoMetalDAO {
        if (self::$instance == NULL) {
            self::$instance = new TipoMetalDAO();
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
        return $this->execute("SELECT * FROM tipo_metal ORDER BY tmetal_id");
    }

    public function getById($tmetal_id) {
        $tmetal_id = (int)$tmetal_id;
        return $this->execute("SELECT * FROM tipo_metal WHERE tmetal_id = $tmetal_id");
    }

    public function existsById($tmetal_id): bool {
        $tmetal_id = (int)$tmetal_id;
        $rs = $this->execute("SELECT 1 FROM tipo_metal WHERE tmetal_id = $tmetal_id LIMIT 1");
        return mysqli_num_rows($rs) > 0;
    }

    public function insert($data) {
        $sql = "INSERT INTO tipo_metal (tmetal_id, tmetal_descripcion, tmetal_estado)
                VALUES (
                    " . (int)$data['tmetal_id'] . ",
                    " . $this->str($data['tmetal_descripcion']) . ",
                    " . $this->str($data['tmetal_estado']) . "
                )";
        return $this->execute($sql);
    }

    public function update($tmetal_id, $data) {
        $tmetal_id = (int)$tmetal_id;
        $sql = "UPDATE tipo_metal SET
                    tmetal_descripcion = " . $this->str($data['tmetal_descripcion']) . ",
                    tmetal_estado = " . $this->str($data['tmetal_estado']) . "
                WHERE tmetal_id = $tmetal_id";
        return $this->execute($sql);
    }

    public function delete($tmetal_id) {
        $tmetal_id = (int)$tmetal_id;
        return $this->execute("DELETE FROM tipo_metal WHERE tmetal_id = $tmetal_id");
    }
}
