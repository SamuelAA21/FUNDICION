<?php
include_once '../Lib/Config/conexionSqli.php';

class HornoDAO extends Connection
{
    public function getAll(): array
    {
        return $this->fetchAll(
            'SELECT h.*, c.com_descripcion
             FROM horno h
             LEFT JOIN combustible c ON h.com_id = c.com_id
             ORDER BY h.hor_id'
        );
    }

    public function getById(int $hor_id): ?array
    {
        return $this->fetchOne('SELECT * FROM horno WHERE hor_id = ?', 'i', [$hor_id]);
    }

    public function insertRecord(string $hor_descripcion, int $com_id, int $hor_estado): bool
    {
        return $this->executeStatement(
            'INSERT INTO horno (hor_descripcion, com_id, hor_estado) VALUES (?, ?, ?)',
            'sii',
            [trim($hor_descripcion), $com_id, $hor_estado]
        );
    }

    public function updateRecord(int $hor_id, string $hor_descripcion, int $com_id, int $hor_estado): bool
    {
        return $this->executeStatement(
            'UPDATE horno SET hor_descripcion = ?, com_id = ?, hor_estado = ? WHERE hor_id = ?',
            'siii',
            [trim($hor_descripcion), $com_id, $hor_estado, $hor_id]
        );
    }

    public function deleteRecord(int $hor_id): bool
    {
        return $this->executeStatement('DELETE FROM horno WHERE hor_id = ?', 'i', [$hor_id]);
    }
}
