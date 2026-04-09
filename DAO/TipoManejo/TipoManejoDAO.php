<?php
include_once '../Lib/Config/conexionSqli.php';

class TipoManejoDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): TipoManejoDAO {
        if (self::$instance == NULL) {
            self::$instance = new TipoManejoDAO();
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
        return $this->execute("SELECT * FROM tipo_manejo ORDER BY tmanejo_id");
    }

    public function getById($tmanejo_id) {
        $tmanejo_id = (int)$tmanejo_id;
        return $this->execute("SELECT * FROM tipo_manejo WHERE tmanejo_id = $tmanejo_id");
    }

    public function existsById($tmanejo_id): bool {
        $tmanejo_id = (int)$tmanejo_id;
        $rs = $this->execute("SELECT 1 FROM tipo_manejo WHERE tmanejo_id = $tmanejo_id LIMIT 1");
        return mysqli_num_rows($rs) > 0;
    }

    public function insert($data) {
        $sql = "INSERT INTO tipo_manejo (tmanejo_id, tmanejo_descripcion, tmanejo_estado)
                VALUES (
                    " . (int)$data['tmanejo_id'] . ",
                    " . $this->str($data['tmanejo_descripcion']) . ",
                    " . $this->str($data['tmanejo_estado']) . "
                )";
        return $this->execute($sql);
    }

    public function update($tmanejo_id, $data) {
        $tmanejo_id = (int)$tmanejo_id;
        $sql = "UPDATE tipo_manejo SET
                    tmanejo_descripcion = " . $this->str($data['tmanejo_descripcion']) . ",
                    tmanejo_estado = " . $this->str($data['tmanejo_estado']) . "
                WHERE tmanejo_id = $tmanejo_id";
        return $this->execute($sql);
    }

    public function delete($tmanejo_id) {
        $tmanejo_id = (int)$tmanejo_id;
        return $this->execute("DELETE FROM tipo_manejo WHERE tmanejo_id = $tmanejo_id");
    }
}
