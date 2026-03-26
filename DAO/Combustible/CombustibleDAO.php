<?php
include_once '../Lib/Config/conexionSqli.php';

class CombustibleDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): CombustibleDAO {
        if (self::$instance == NULL) {
            self::$instance = new CombustibleDAO();
        }
        return self::$instance;
    }

    public function getAll() {
        $sql = "SELECT com_id, com_descripcion, com_estado FROM combustible";
        return $this->execute($sql);
    }

    public function getById($comb_id) {
        $comb_id = (int)$comb_id;
        $sql = "SELECT com_id, com_descripcion, com_estado FROM combustible WHERE com_id = $comb_id";
        return $this->execute($sql);
    }

    public function insert($comb_descripcion, $comb_estado) {
        $comb_descripcion = mysqli_real_escape_string($this->getConnect(), $comb_descripcion);
        $comb_estado = (int)$comb_estado;

        $sql = "INSERT INTO combustible (com_descripcion, com_estado)
                VALUES ('$comb_descripcion', $comb_estado)";
        return $this->execute($sql);
    }

    public function update($comb_id, $comb_descripcion, $comb_estado) {
        $comb_id = (int)$comb_id;
        $comb_descripcion = mysqli_real_escape_string($this->getConnect(), $comb_descripcion);
        $comb_estado = (int)$comb_estado;

        $sql = "UPDATE combustible
                SET com_descripcion = '$comb_descripcion',
                    com_estado = $comb_estado
                WHERE com_id = $comb_id";
        return $this->execute($sql);
    }

    public function delete($comb_id) {
        $comb_id = (int)$comb_id;
        $sql = "DELETE FROM combustible WHERE com_id = $comb_id";
        return $this->execute($sql);
    }
}