<?php
include_once '../Lib/Config/conexionSqli.php';

class TipoMetalDAO extends Connection
{
    public function getAll(): array
    {
        return $this->fetchAll('SELECT * FROM tipo_metal ORDER BY tmetal_id');
    }

    public function getById(int $tmetal_id): ?array
    {
        return $this->fetchOne('SELECT * FROM tipo_metal WHERE tmetal_id = ?', 'i', [$tmetal_id]);
    }

    public function existsById(int $tmetal_id): bool
    {
        return $this->getById($tmetal_id) !== null;
    }

    public function insertRecord(string $tmetal_descripcion, int $tmetal_estado): bool
    {
        return $this->executeStatement(
            'INSERT INTO tipo_metal (tmetal_descripcion, tmetal_estado) VALUES (?, ?)',
            'si',
            [trim($tmetal_descripcion), $tmetal_estado]
        );
    }

    public function updateRecord(int $tmetal_id, string $tmetal_descripcion, int $tmetal_estado): bool
    {
        return $this->executeStatement(
            'UPDATE tipo_metal SET tmetal_descripcion = ?, tmetal_estado = ? WHERE tmetal_id = ?',
            'sii',
            [trim($tmetal_descripcion), $tmetal_estado, $tmetal_id]
        );
    }

    public function deleteRecord(int $tmetal_id): bool
    {
        return $this->executeStatement('DELETE FROM tipo_metal WHERE tmetal_id = ?', 'i', [$tmetal_id]);
    }
}
