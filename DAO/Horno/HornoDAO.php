<?php
include_once '../Lib/Config/conexionSqli.php';

class HornoDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): HornoDAO {
        if (self::$instance == NULL) {
            self::$instance = new HornoDAO();
        }
        return self::$instance;
    }

    public function getAll() {
        $sql = "SELECT h.*, c.com_descripcion FROM horno h LEFT JOIN combustible c ON h.com_id = c.com_id";
        return $this->execute($sql);
    }

    public function getById($hor_id) {
        $hor_id = (int)$hor_id;
        $sql = "SELECT * FROM horno WHERE hor_id = $hor_id";
        return $this->execute($sql);
    }

    public function insert($hor_descripcion, $com_id, $hor_estado) {
        $hor_descripcion = mysqli_real_escape_string($this->getConnect(), $hor_descripcion);
        $com_id = (int)$com_id;
        $hor_estado = (int)$hor_estado;

        $sql = "INSERT INTO horno (hor_descripcion, com_id, hor_estado) VALUES ('$hor_descripcion', $com_id, $hor_estado)";
        return $this->execute($sql);
    }

    public function update($hor_id, $hor_descripcion, $com_id, $hor_estado) {
        $hor_id = (int)$hor_id;
        $hor_descripcion = mysqli_real_escape_string($this->getConnect(), $hor_descripcion);
        $com_id = (int)$com_id;
        $hor_estado = (int)$hor_estado;

        $sql = "UPDATE horno SET hor_descripcion = '$hor_descripcion', com_id = $com_id, hor_estado = $hor_estado WHERE hor_id = $hor_id";
        return $this->execute($sql);
    }

    public function delete($hor_id) {
        $hor_id = (int)$hor_id;
        $sql = "DELETE FROM horno WHERE hor_id = $hor_id";
        return $this->execute($sql);
    }
}
