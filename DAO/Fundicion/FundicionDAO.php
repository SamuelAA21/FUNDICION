<?php
include_once '../Lib/Config/conexionSqli.php';

class FundicionDAO extends Connection {

    private function esc($value) {
        return mysqli_real_escape_string($this->getConnect(), trim((string)$value));
    }

    public function getNextRegistroId() {
        $rs = $this->execute("SELECT COALESCE(MAX(rfun_id), 0) + 1 AS next_id FROM registro_fundicion");
        $row = mysqli_fetch_assoc($rs);
        return (int)($row['next_id'] ?? 1);
    }

    public function getNextDetalleId() {
        $rs = $this->execute("SELECT COALESCE(MAX(dfun_id), 0) + 1 AS next_id FROM detalle_fundicion");
        $row = mysqli_fetch_assoc($rs);
        return (int)($row['next_id'] ?? 1);
    }

    public function getResponsablesList() {
        return $this->execute("
            SELECT usu_login, usu_nombres, usu_apellidos
            FROM usuario
            WHERE usu_estado IN ('1', 'Activo', 'ACTIVO')
            ORDER BY usu_nombres, usu_apellidos
        ");
    }

    public function getMateriasPrimasList() {
        return $this->execute("
            SELECT mat_codigo, mat_descripcion
            FROM materia_prima
            WHERE mat_estado IN ('1', 'Activo', 'ACTIVO')
            ORDER BY mat_descripcion
        ");
    }

    public function getClientesList() {
        return $this->execute("
            SELECT cli_nit, cli_razon_social
            FROM cliente
            WHERE cli_estado IN ('1', 'Activo', 'ACTIVO')
            ORDER BY cli_razon_social
        ");
    }

    public function getProductosTerminadosList() {
        return $this->execute("
            SELECT pro_id, pro_nombre
            FROM producto_terminado
            WHERE pro_estado IN ('1', 'Activo', 'ACTIVO')
            ORDER BY pro_nombre
        ");
    }

    public function getHornosList() {
        return $this->execute("
            SELECT h.hor_id, h.hor_descripcion, h.com_id, c.com_descripcion
            FROM horno h
            LEFT JOIN combustible c ON c.com_id = h.com_id
            WHERE h.hor_estado IN ('1', 'Activo', 'ACTIVO')
            ORDER BY h.hor_descripcion
        ");
    }

    public function getReportList() {
        return $this->execute("
            SELECT
                rf.rfun_id,
                rf.rfun_fecha,
                rf.usu_responsable,
                rf.rfun_observacion,
                CONCAT(COALESCE(u.usu_nombres, ''), ' ', COALESCE(u.usu_apellidos, '')) AS responsable_nombre,
                mp.mat_descripcion,
                df.dfun_cantidad,
                c.cli_razon_social,
                pt.pro_nombre,
                df.dfun_cantprot,
                df.dfun_cantesc,
                h.hor_descripcion,
                co.com_descripcion,
                df.dfun_cantidad_com,
                df.dfun_hinicio,
                df.dfun_hfin,
                df.dfun_per_metal
            FROM registro_fundicion rf
            INNER JOIN detalle_fundicion df ON df.rfun_id = rf.rfun_id
            LEFT JOIN usuario u ON u.usu_login = rf.usu_responsable
            LEFT JOIN materia_prima mp ON mp.mat_codigo = df.mat_codigo
            LEFT JOIN cliente c ON c.cli_nit = df.Cli_mat
            LEFT JOIN producto_terminado pt ON pt.pro_id = df.pro_id
            LEFT JOIN horno h ON h.hor_id = df.hor_id
            LEFT JOIN combustible co ON co.com_id = df.com_id
            ORDER BY rf.rfun_fecha DESC, rf.rfun_id DESC, df.dfun_id DESC
        ");
    }

    public function getCombustibleIdByHorno($hor_id) {
        $hor_id = (int)$hor_id;
        $rs = $this->execute("SELECT com_id FROM horno WHERE hor_id = $hor_id LIMIT 1");
        $row = mysqli_fetch_assoc($rs);
        return (int)($row['com_id'] ?? 0);
    }

    public function insertRegistroFundicion($rfun_id, $rfun_fecha, $usu_responsable, $rfun_observacion, $usu_crea) {
        $rfun_id = (int)$rfun_id;
        $rfun_fecha = $this->esc($rfun_fecha);
        $usu_responsable = $this->esc($usu_responsable);
        $rfun_observacion = $this->esc($rfun_observacion);
        $usu_crea = $this->esc($usu_crea);

        $sql = "INSERT INTO registro_fundicion (rfun_id, rfun_fecha, usu_responsable, rfun_observacion, usu_crea)
                VALUES ($rfun_id, '$rfun_fecha', '$usu_responsable', '$rfun_observacion', '$usu_crea')";
        return $this->execute($sql);
    }

    public function insertDetalleFundicion(
        $dfun_id,
        $rfun_id,
        $mat_codigo,
        $cli_mat,
        $dfun_cantidad,
        $pro_id,
        $dfun_cantprot,
        $esc_id,
        $dfun_cantesc,
        $hor_id,
        $com_id,
        $dfun_cantidad_com,
        $dfun_hinicio,
        $dfun_hfin,
        $dfun_per_metal,
        $dfun_num_docrres
    ) {
        $dfun_id = (int)$dfun_id;
        $rfun_id = (int)$rfun_id;
        $mat_codigo = (int)$mat_codigo;
        $cli_mat = $this->esc($cli_mat);
        $dfun_cantidad = (float)$dfun_cantidad;
        $pro_id = (int)$pro_id;
        $dfun_cantprot = (float)$dfun_cantprot;
        $esc_id = (int)$esc_id;
        $dfun_cantesc = (float)$dfun_cantesc;
        $hor_id = (int)$hor_id;
        $com_id = (int)$com_id;
        $dfun_cantidad_com = (float)$dfun_cantidad_com;
        $dfun_hinicio = $this->esc($dfun_hinicio);
        $dfun_hfin = $this->esc($dfun_hfin);
        $dfun_per_metal = (int)$dfun_per_metal;
        $dfun_num_docrres = (int)$dfun_num_docrres;

        $sql = "INSERT INTO detalle_fundicion (
                    dfun_id, rfun_id, mat_codigo, Cli_mat, dfun_cantidad, pro_id, dfun_cantprot,
                    esc_id, dfun_cantesc, hor_id, com_id, dfun_cantidad_com, dfun_hinicio,
                    dfun_hfin, dfun_per_metal, dfun_num_docrres
                ) VALUES (
                    $dfun_id, $rfun_id, $mat_codigo, '$cli_mat', $dfun_cantidad, $pro_id, $dfun_cantprot,
                    $esc_id, $dfun_cantesc, $hor_id, $com_id, $dfun_cantidad_com, '$dfun_hinicio',
                    '$dfun_hfin', $dfun_per_metal, $dfun_num_docrres
                )";
        return $this->execute($sql);
    }
}
