<?php
include_once '../Lib/Config/conexionSqli.php';

class CombustibleDAO extends Connection
{
    public function getAll(): array
    {
        return $this->fetchAll(
            'SELECT com_id, com_descripcion, com_estado FROM combustible ORDER BY com_id'
        );
    }

    public function getById(int $comb_id): ?array
    {
        return $this->fetchOne(
            'SELECT com_id, com_descripcion, com_estado FROM combustible WHERE com_id = ?',
            'i',
            [$comb_id]
        );
    }

    public function insertRecord(string $comb_descripcion, int $comb_estado): bool
    {
        return $this->executeStatement(
            'INSERT INTO combustible (com_descripcion, com_estado) VALUES (?, ?)',
            'si',
            [trim($comb_descripcion), $comb_estado]
        );
    }

    public function updateRecord(int $comb_id, string $comb_descripcion, int $comb_estado): bool
    {
        return $this->executeStatement(
            'UPDATE combustible SET com_descripcion = ?, com_estado = ? WHERE com_id = ?',
            'sii',
            [trim($comb_descripcion), $comb_estado, $comb_id]
        );
    }

    public function deleteRecord(int $comb_id): bool
    {
        return $this->executeStatement('DELETE FROM combustible WHERE com_id = ?', 'i', [$comb_id]);
    }
}
