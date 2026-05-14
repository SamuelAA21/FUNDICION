<?php
include_once '../Lib/Config/conexionSqli.php';

class FundicionDAO extends Connection
{
    public function getNextRegistroId(): int
    {
        $row = $this->fetchOne(
            'SELECT COALESCE(MAX(rfun_id), 0) + 1 AS next_id FROM registro_fundicion'
        );
        return (int)($row['next_id'] ?? 1);
    }

    public function getNextDetalleId(): int
    {
        $row = $this->fetchOne(
            'SELECT COALESCE(MAX(dfun_id), 0) + 1 AS next_id FROM detalle_fundicion'
        );
        return (int)($row['next_id'] ?? 1);
    }

    public function getResponsablesList(): array
    {
        return $this->fetchAll(
            "SELECT usu_login, usu_nombres, usu_apellidos
             FROM usuario
             WHERE usu_estado IN ('1', 'Activo', 'ACTIVO')
             ORDER BY usu_nombres, usu_apellidos"
        );
    }

    public function getMateriasPrimasList(): array
    {
        return $this->fetchAll(
            "SELECT mat_codigo, mat_descripcion
             FROM materia_prima
             WHERE mat_estado IN ('1', 'Activo', 'ACTIVO')
             ORDER BY mat_descripcion"
        );
    }

    public function getClientesList(): array
    {
        return $this->fetchAll(
            "SELECT cli_nit, cli_razon_social
             FROM cliente
             WHERE cli_estado IN ('1', 'Activo', 'ACTIVO')
             ORDER BY cli_razon_social"
        );
    }

    public function getProductosTerminadosList(): array
    {
        return $this->fetchAll(
            "SELECT pro_id, pro_nombre
             FROM producto_terminado
             WHERE pro_estado IN ('1', 'Activo', 'ACTIVO')
             ORDER BY pro_nombre"
        );
    }

    public function getHornosList(): array
    {
        return $this->fetchAll(
            "SELECT h.hor_id, h.hor_descripcion, h.com_id, c.com_descripcion
             FROM horno h
             LEFT JOIN combustible c ON c.com_id = h.com_id
             WHERE h.hor_estado IN ('1', 'Activo', 'ACTIVO')
             ORDER BY h.hor_descripcion"
        );
    }

    public function getCombustibleIdByHorno(int $hor_id): int
    {
        $row = $this->fetchOne(
            'SELECT com_id FROM horno WHERE hor_id = ? LIMIT 1',
            'i',
            [$hor_id]
        );
        return (int)($row['com_id'] ?? 0);
    }

    public function saveFundicion(array $registro, array $detalle): bool
    {
        return $this->executeInTransaction(function () use ($registro, $detalle) {
            $registroOk = $this->executeStatement(
                'INSERT INTO registro_fundicion (rfun_id, rfun_fecha, usu_responsable, rfun_observacion, usu_crea)
                 VALUES (?, ?, ?, ?, ?)',
                'issss',
                [
                    (int)$registro['rfun_id'],
                    trim((string)$registro['rfun_fecha']),
                    trim((string)$registro['usu_responsable']),
                    trim((string)$registro['rfun_observacion']),
                    trim((string)$registro['usu_crea'])
                ]
            );

            if (!$registroOk) {
                return false;
            }

            return $this->executeStatement(
                'INSERT INTO detalle_fundicion (
                    dfun_id, rfun_id, mat_codigo, Cli_mat, dfun_cantidad, pro_id, dfun_cantprot,
                    esc_id, dfun_cantesc, hor_id, com_id, dfun_cantidad_com, dfun_hinicio,
                    dfun_hfin, dfun_per_metal, dfun_num_docrres
                 ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                'iiisdididiidssii',
                [
                    (int)$detalle['dfun_id'],
                    (int)$detalle['rfun_id'],
                    (int)$detalle['mat_codigo'],
                    trim((string)$detalle['cli_mat']),
                    (float)$detalle['dfun_cantidad'],
                    (int)$detalle['pro_id'],
                    (float)$detalle['dfun_cantprot'],
                    (int)$detalle['esc_id'],
                    (float)$detalle['dfun_cantesc'],
                    (int)$detalle['hor_id'],
                    (int)$detalle['com_id'],
                    (float)$detalle['dfun_cantidad_com'],
                    trim((string)$detalle['dfun_hinicio']),
                    trim((string)$detalle['dfun_hfin']),
                    (int)$detalle['dfun_per_metal'],
                    (int)$detalle['dfun_num_docrres']
                ]
            );
        });
    }
}
