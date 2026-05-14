<?php
include_once '../Lib/Config/conexionSqli.php';

class BodegaDAO extends Connection
{
    public function getAll(): array
    {
        return $this->fetchAll('SELECT * FROM bodega ORDER BY bod_id');
    }

    public function getById(int $bod_id): ?array
    {
        return $this->fetchOne('SELECT * FROM bodega WHERE bod_id = ?', 'i', [$bod_id]);
    }

    public function existsById(int $bod_id): bool
    {
        return $this->getById($bod_id) !== null;
    }

    public function insertRecord(array $data): bool
    {
        return $this->executeStatement(
            'INSERT INTO bodega (bod_id, bod_descripcion, bod_capacidad, bod_area, bod_estado)
             VALUES (?, ?, ?, ?, ?)',
            'issss',
            [
                (int)$data['bod_id'],
                trim((string)$data['bod_descripcion']),
                trim((string)$data['bod_capacidad']),
                trim((string)$data['bod_area']),
                trim((string)$data['bod_estado'])
            ]
        );
    }

    public function updateRecord(int $bod_id, array $data): bool
    {
        return $this->executeStatement(
            'UPDATE bodega
             SET bod_descripcion = ?, bod_capacidad = ?, bod_area = ?, bod_estado = ?
             WHERE bod_id = ?',
            'ssssi',
            [
                trim((string)$data['bod_descripcion']),
                trim((string)$data['bod_capacidad']),
                trim((string)$data['bod_area']),
                trim((string)$data['bod_estado']),
                $bod_id
            ]
        );
    }

    public function deleteRecord(int $bod_id): bool
    {
        return $this->executeStatement('DELETE FROM bodega WHERE bod_id = ?', 'i', [$bod_id]);
    }
}
