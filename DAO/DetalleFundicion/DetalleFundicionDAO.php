<?php
include_once '../Lib/Config/conexionSqli.php';

class DetalleFundicionDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): DetalleFundicionDAO {
        if (self::$instance == NULL) {
            self::$instance = new DetalleFundicionDAO();
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
        $sql = "SELECT df.*, mp.mat_descripcion, c.cli_razon_social, pt.pro_nombre,
                       h.hor_descripcion, co.com_descripcion
                FROM detalle_fundicion df
                LEFT JOIN materia_prima mp ON df.mat_codigo = mp.mat_codigo
                LEFT JOIN cliente c ON df.Cli_mat = c.cli_nit
                LEFT JOIN producto_terminado pt ON df.pro_id = pt.pro_id
                LEFT JOIN horno h ON df.hor_id = h.hor_id
                LEFT JOIN combustible co ON df.com_id = co.com_id";
        return $this->execute($sql);
    }

    public function getById($dfun_id) {
        $dfun_id = (int)$dfun_id;
        return $this->execute("SELECT * FROM detalle_fundicion WHERE dfun_id = $dfun_id");
    }

    public function insert($data) {
        $sql = "INSERT INTO detalle_fundicion (
                    dfun_id, rfun_id, mat_codigo, Cli_mat, dfun_cantidad, pro_id,
                    dfun_cantprot, esc_id, dfun_cantesc, hor_id, com_id,
                    dfun_cantidad_com, dfun_hinicio, dfun_hfin, dfun_per_metal, dfun_num_docrres
                ) VALUES (
                    " . (int)$data['dfun_id'] . ",
                    " . (int)$data['rfun_id'] . ",
                    " . (int)$data['mat_codigo'] . ",
                    " . $this->str($data['Cli_mat']) . ",
                    " . (double)$data['dfun_cantidad'] . ",
                    " . (int)$data['pro_id'] . ",
                    " . (double)$data['dfun_cantprot'] . ",
                    " . (int)$data['esc_id'] . ",
                    " . (double)$data['dfun_cantesc'] . ",
                    " . (int)$data['hor_id'] . ",
                    " . (int)$data['com_id'] . ",
                    " . (double)$data['dfun_cantidad_com'] . ",
                    " . $this->str($data['dfun_hinicio']) . ",
                    " . $this->str($data['dfun_hfin']) . ",
                    " . (int)$data['dfun_per_metal'] . ",
                    " . (int)$data['dfun_num_docrres'] . "
                )";
        return $this->execute($sql);
    }

    public function update($dfun_id, $data) {
        $dfun_id = (int)$dfun_id;
        $sql = "UPDATE detalle_fundicion SET
                    rfun_id = " . (int)$data['rfun_id'] . ",
                    mat_codigo = " . (int)$data['mat_codigo'] . ",
                    Cli_mat = " . $this->str($data['Cli_mat']) . ",
                    dfun_cantidad = " . (double)$data['dfun_cantidad'] . ",
                    pro_id = " . (int)$data['pro_id'] . ",
                    dfun_cantprot = " . (double)$data['dfun_cantprot'] . ",
                    esc_id = " . (int)$data['esc_id'] . ",
                    dfun_cantesc = " . (double)$data['dfun_cantesc'] . ",
                    hor_id = " . (int)$data['hor_id'] . ",
                    com_id = " . (int)$data['com_id'] . ",
                    dfun_cantidad_com = " . (double)$data['dfun_cantidad_com'] . ",
                    dfun_hinicio = " . $this->str($data['dfun_hinicio']) . ",
                    dfun_hfin = " . $this->str($data['dfun_hfin']) . ",
                    dfun_per_metal = " . (int)$data['dfun_per_metal'] . ",
                    dfun_num_docrres = " . (int)$data['dfun_num_docrres'] . "
                WHERE dfun_id = $dfun_id";
        return $this->execute($sql);
    }

    public function delete($dfun_id) {
        $dfun_id = (int)$dfun_id;
        return $this->execute("DELETE FROM detalle_fundicion WHERE dfun_id = $dfun_id");
    }

    public function getRegistrosFundicion() {
        return $this->execute("SELECT rfun_id FROM registro_fundicion ORDER BY rfun_id DESC");
    }

    public function getMateriasPrimas() {
        return $this->execute("SELECT mat_codigo, mat_descripcion FROM materia_prima ORDER BY mat_descripcion");
    }

    public function getClientes() {
        return $this->execute("SELECT cli_nit, cli_razon_social FROM cliente ORDER BY cli_razon_social");
    }

    public function getProductosTerminados() {
        return $this->execute("SELECT pro_id, pro_nombre FROM producto_terminado ORDER BY pro_nombre");
    }

    public function getHornos() {
        return $this->execute("SELECT hor_id, hor_descripcion FROM horno ORDER BY hor_descripcion");
    }

    public function getCombustibles() {
        return $this->execute("SELECT com_id, com_descripcion FROM combustible ORDER BY com_descripcion");
    }
}
