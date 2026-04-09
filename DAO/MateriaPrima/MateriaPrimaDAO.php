<?php
include_once '../Lib/Config/conexionSqli.php';

class MateriaPrimaDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): MateriaPrimaDAO {
        if (self::$instance == NULL) {
            self::$instance = new MateriaPrimaDAO();
        }
        return self::$instance;
    }

    private function esc($value) {
        return mysqli_real_escape_string($this->getConnect(), trim((string)$value));
    }

    private function str($value) {
        return "'" . $this->esc($value) . "'";
    }

    private function nullableStr($value) {
        if ($value === null || trim((string)$value) === '') {
            return "NULL";
        }
        return "'" . $this->esc($value) . "'";
    }

    private function nullableInt($value) {
        if ($value === null || $value === '') {
            return "NULL";
        }
        return (string)((int)$value);
    }

    public function getAll() {
        $sql = "SELECT mp.*, tm.tmetal_descripcion, em.ematp_descripcion, pr.pres_descripcion,
                       bo.bod_descripcion, tp.tpel_descripcion, pt.pro_nombre
                FROM materia_prima mp
                LEFT JOIN tipo_metal tm ON mp.tmetal_id = tm.tmetal_id
                LEFT JOIN estado_materia em ON mp.ematp_id = em.ematp_id
                LEFT JOIN presentacion pr ON mp.pres_id = pr.pres_id
                LEFT JOIN bodega bo ON mp.bod_id = bo.bod_id
                LEFT JOIN tipo_peligro tp ON mp.tpel_id = tp.tpel_id
                LEFT JOIN producto_terminado pt ON mp.pro_id = pt.pro_id";
        return $this->execute($sql);
    }

    public function getById($mat_codigo) {
        $mat_codigo = (int)$mat_codigo;
        return $this->execute("SELECT * FROM materia_prima WHERE mat_codigo = $mat_codigo");
    }

    public function existsById($mat_codigo): bool {
        $mat_codigo = (int)$mat_codigo;
        $rs = $this->execute("SELECT 1 FROM materia_prima WHERE mat_codigo = $mat_codigo LIMIT 1");
        return mysqli_num_rows($rs) > 0;
    }

    public function insert($data) {
        $sql = "INSERT INTO materia_prima (
                    mat_codigo, mat_descripcion, mat_peligrosidad, tmetal_id, ematp_id,
                    pres_id, corr_id, bod_id, tpel_id, pro_id, mat_estado
                ) VALUES (
                    " . (int)$data['mat_codigo'] . ",
                    " . $this->nullableStr($data['mat_descripcion']) . ",
                    " . $this->str($data['mat_peligrosidad']) . ",
                    " . (int)$data['tmetal_id'] . ",
                    " . (int)$data['ematp_id'] . ",
                    " . (int)$data['pres_id'] . ",
                    " . (int)$data['corr_id'] . ",
                    " . (int)$data['bod_id'] . ",
                    " . $this->nullableInt($data['tpel_id']) . ",
                    " . (int)$data['pro_id'] . ",
                    " . $this->str($data['mat_estado']) . "
                )";
        return $this->execute($sql);
    }

    public function update($mat_codigo, $data) {
        $mat_codigo = (int)$mat_codigo;
        $sql = "UPDATE materia_prima SET
                    mat_descripcion = " . $this->nullableStr($data['mat_descripcion']) . ",
                    mat_peligrosidad = " . $this->str($data['mat_peligrosidad']) . ",
                    tmetal_id = " . (int)$data['tmetal_id'] . ",
                    ematp_id = " . (int)$data['ematp_id'] . ",
                    pres_id = " . (int)$data['pres_id'] . ",
                    corr_id = " . (int)$data['corr_id'] . ",
                    bod_id = " . (int)$data['bod_id'] . ",
                    tpel_id = " . $this->nullableInt($data['tpel_id']) . ",
                    pro_id = " . (int)$data['pro_id'] . ",
                    mat_estado = " . $this->str($data['mat_estado']) . "
                WHERE mat_codigo = $mat_codigo";
        return $this->execute($sql);
    }

    public function delete($mat_codigo) {
        $mat_codigo = (int)$mat_codigo;
        return $this->execute("DELETE FROM materia_prima WHERE mat_codigo = $mat_codigo");
    }

    public function getTiposMetal() {
        return $this->execute("SELECT tmetal_id, tmetal_descripcion FROM tipo_metal ORDER BY tmetal_descripcion");
    }

    public function getEstadosMateria() {
        return $this->execute("SELECT ematp_id, ematp_descripcion FROM estado_materia ORDER BY ematp_descripcion");
    }

    public function getPresentaciones() {
        return $this->execute("SELECT pres_id, pres_descripcion FROM presentacion ORDER BY pres_descripcion");
    }

    public function getBodegas() {
        return $this->execute("SELECT bod_id, bod_descripcion FROM bodega ORDER BY bod_descripcion");
    }

    public function getTiposPeligro() {
        return $this->execute("SELECT tpel_id, tpel_descripcion FROM tipo_peligro ORDER BY tpel_descripcion");
    }

    public function getProductosTerminados() {
        return $this->execute("SELECT pro_id, pro_nombre FROM producto_terminado ORDER BY pro_nombre");
    }
}
