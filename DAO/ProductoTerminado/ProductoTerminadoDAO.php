<?php
include_once '../Lib/Config/conexionSqli.php';

class ProductoTerminadoDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): ProductoTerminadoDAO {
        if (self::$instance == NULL) {
            self::$instance = new ProductoTerminadoDAO();
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
        $sql = "SELECT pt.*, tm.tmetal_descripcion, pr.pres_descripcion, bo.bod_descripcion
                FROM producto_terminado pt
                LEFT JOIN tipo_metal tm ON pt.tmetal_id = tm.tmetal_id
                LEFT JOIN presentacion pr ON pt.pres_id = pr.pres_id
                LEFT JOIN bodega bo ON pt.bod_id = bo.bod_id";
        return $this->execute($sql);
    }

    public function getById($pro_id) {
        $pro_id = (int)$pro_id;
        return $this->execute("SELECT * FROM producto_terminado WHERE pro_id = $pro_id");
    }

    public function existsById($pro_id): bool {
        $pro_id = (int)$pro_id;
        $rs = $this->execute("SELECT 1 FROM producto_terminado WHERE pro_id = $pro_id LIMIT 1");
        return mysqli_num_rows($rs) > 0;
    }

    public function insert($data) {
        $sql = "INSERT INTO producto_terminado (pro_id, pro_nombre, tmetal_id, pres_id, bod_id, pro_estado)
                VALUES (
                    " . (int)$data['pro_id'] . ",
                    " . $this->str($data['pro_nombre']) . ",
                    " . (int)$data['tmetal_id'] . ",
                    " . (int)$data['pres_id'] . ",
                    " . (int)$data['bod_id'] . ",
                    " . $this->str($data['pro_estado']) . "
                )";
        return $this->execute($sql);
    }

    public function update($pro_id, $data) {
        $pro_id = (int)$pro_id;
        $sql = "UPDATE producto_terminado SET
                    pro_nombre = " . $this->str($data['pro_nombre']) . ",
                    tmetal_id = " . (int)$data['tmetal_id'] . ",
                    pres_id = " . (int)$data['pres_id'] . ",
                    bod_id = " . (int)$data['bod_id'] . ",
                    pro_estado = " . $this->str($data['pro_estado']) . "
                WHERE pro_id = $pro_id";
        return $this->execute($sql);
    }

    public function delete($pro_id) {
        $pro_id = (int)$pro_id;
        return $this->execute("DELETE FROM producto_terminado WHERE pro_id = $pro_id");
    }

    public function getTiposMetal() {
        return $this->execute("SELECT tmetal_id, tmetal_descripcion FROM tipo_metal ORDER BY tmetal_descripcion");
    }

    public function getPresentaciones() {
        return $this->execute("SELECT pres_id, pres_descripcion FROM presentacion ORDER BY pres_descripcion");
    }

    public function getBodegas() {
        return $this->execute("SELECT bod_id, bod_descripcion FROM bodega ORDER BY bod_descripcion");
    }
}
