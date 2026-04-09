<?php
include_once '../Lib/Config/conexionSqli.php';

class TipoPeligroDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): TipoPeligroDAO {
        if (self::$instance == NULL) {
            self::$instance = new TipoPeligroDAO();
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
        return $this->execute("SELECT * FROM tipo_peligro ORDER BY tpel_id");
    }

    public function getById($tpel_id) {
        $tpel_id = (int)$tpel_id;
        return $this->execute("SELECT * FROM tipo_peligro WHERE tpel_id = $tpel_id");
    }

    public function existsById($tpel_id): bool {
        $tpel_id = (int)$tpel_id;
        $rs = $this->execute("SELECT 1 FROM tipo_peligro WHERE tpel_id = $tpel_id LIMIT 1");
        return mysqli_num_rows($rs) > 0;
    }

    public function insert($data) {
        $sql = "INSERT INTO tipo_peligro (tpel_id, tpel_descripcion, tpel_especifica, tpel_estado)
                VALUES (
                    " . (int)$data['tpel_id'] . ",
                    " . $this->str($data['tpel_descripcion']) . ",
                    " . $this->str($data['tpel_especifica']) . ",
                    " . $this->str($data['tpel_estado']) . "
                )";
        return $this->execute($sql);
    }

    public function update($tpel_id, $data) {
        $tpel_id = (int)$tpel_id;
        $sql = "UPDATE tipo_peligro SET
                    tpel_descripcion = " . $this->str($data['tpel_descripcion']) . ",
                    tpel_especifica = " . $this->str($data['tpel_especifica']) . ",
                    tpel_estado = " . $this->str($data['tpel_estado']) . "
                WHERE tpel_id = $tpel_id";
        return $this->execute($sql);
    }

    public function delete($tpel_id) {
        $tpel_id = (int)$tpel_id;
        return $this->execute("DELETE FROM tipo_peligro WHERE tpel_id = $tpel_id");
    }
}
