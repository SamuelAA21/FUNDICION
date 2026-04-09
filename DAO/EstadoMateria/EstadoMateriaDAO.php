<?php
include_once '../Lib/Config/conexionSqli.php';

class EstadoMateriaDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): EstadoMateriaDAO {
        if (self::$instance == NULL) {
            self::$instance = new EstadoMateriaDAO();
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
        return $this->execute("SELECT * FROM estado_materia ORDER BY ematp_id");
    }

    public function getById($ematp_id) {
        $ematp_id = (int)$ematp_id;
        return $this->execute("SELECT * FROM estado_materia WHERE ematp_id = $ematp_id");
    }

    public function existsById($ematp_id): bool {
        $ematp_id = (int)$ematp_id;
        $rs = $this->execute("SELECT 1 FROM estado_materia WHERE ematp_id = $ematp_id LIMIT 1");
        return mysqli_num_rows($rs) > 0;
    }

    public function insert($data) {
        $sql = "INSERT INTO estado_materia (ematp_id, ematp_descripcion)
                VALUES (
                    " . (int)$data['ematp_id'] . ",
                    " . $this->str($data['ematp_descripcion']) . "
                )";
        return $this->execute($sql);
    }

    public function update($ematp_id, $data) {
        $ematp_id = (int)$ematp_id;
        $sql = "UPDATE estado_materia SET
                    ematp_descripcion = " . $this->str($data['ematp_descripcion']) . "
                WHERE ematp_id = $ematp_id";
        return $this->execute($sql);
    }

    public function delete($ematp_id) {
        $ematp_id = (int)$ematp_id;
        return $this->execute("DELETE FROM estado_materia WHERE ematp_id = $ematp_id");
    }
}
