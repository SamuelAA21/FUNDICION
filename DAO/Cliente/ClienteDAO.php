<?php
/* Se abre PHP */

/* Se incluye la conexión */
require_once __DIR__ . '/../../Lib/Config/conexionSqli.php';

/* Se define el DAO */
class ClienteDAO
{
    /* Se define la conexión */
    protected $cn;

    /* Constructor */
    public function __construct()
    {
        /* Opción 1: si tu conexión es un método estático Conexion::conectar() */
        if (class_exists('Conexion') && method_exists('Conexion', 'conectar')) {
            $this->cn = Conexion::conectar();
            return;
        }

        /* Opción 2: si tu conexión es una función conectar() */
        if (function_exists('conectar')) {
            $this->cn = conectar();
            return;
        }

        /* Si no se pudo, deja null */
        $this->cn = null;
    }

    /* Traer todos */
    public function getAll()
    {
        /* Si no hay conexión */
        if ($this->cn === null) {
            return [];
        }

        /* SQL */
        $sql = "SELECT cli_nit, cli_razon_social, cli_dir, cli_tel, cli_correo, cli_nombre_contacto, cli_estado
                FROM cliente";

        /* Ejecuta */
        $rs = $this->cn->query($sql);

        /* Valida */
        if (!$rs) {
            return [];
        }

        /* Arreglo */
        $rows = [];

        /* Recorre */
        while ($row = $rs->fetch_assoc()) {
            $rows[] = $row;
        }

        /* Retorna */
        return $rows;
    }

    /* Traer uno */
    public function getByNit($cli_nit)
    {
        /* Si no hay conexión */
        if ($this->cn === null) {
            return null;
        }

        /* SQL */
        $sql = "SELECT cli_nit, cli_razon_social, cli_dir, cli_tel, cli_correo, cli_nombre_contacto, cli_estado
                FROM cliente
                WHERE cli_nit = ?";

        /* Prepara */
        $stmt = $this->cn->prepare($sql);

        /* Valida */
        if (!$stmt) {
            return null;
        }

        /* Bind */
        $stmt->bind_param("s", $cli_nit);

        /* Ejecuta */
        $stmt->execute();

        /* Resultado */
        $rs = $stmt->get_result();

        /* Fila */
        $row = $rs ? $rs->fetch_assoc() : null;

        /* Cierra */
        $stmt->close();

        /* Retorna */
        return $row;
    }

    /* Insertar */
    public function insert($cli_nit, $cli_razon_social, $cli_dir, $cli_tel, $cli_correo, $cli_nombre_contacto, $cli_estado)
    {
        /* Si no hay conexión */
        if ($this->cn === null) {
            return false;
        }

        /* SQL */
        $sql = "INSERT INTO cliente
                (cli_nit, cli_razon_social, cli_dir, cli_tel, cli_correo, cli_nombre_contacto, cli_estado, Cli_fecha_crea, Cli_usu_crea)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 'system')";

        /* Prepara */
        $stmt = $this->cn->prepare($sql);

        /* Valida */
        if (!$stmt) {
            return false;
        }

        /* Bind */
        $stmt->bind_param(
            "sssssss",
            $cli_nit,
            $cli_razon_social,
            $cli_dir,
            $cli_tel,
            $cli_correo,
            $cli_nombre_contacto,
            $cli_estado
        );

        /* Ejecuta */
        $ok = $stmt->execute();

        /* Cierra */
        $stmt->close();

        /* Retorna */
        return $ok;
    }

    /* Actualizar */
    public function update($cli_nit, $cli_razon_social, $cli_dir, $cli_tel, $cli_correo, $cli_nombre_contacto, $cli_estado)
    {
        /* Si no hay conexión */
        if ($this->cn === null) {
            return false;
        }

        /* SQL */
        $sql = "UPDATE cliente
                SET cli_razon_social = ?, cli_dir = ?, cli_tel = ?, cli_correo = ?, cli_nombre_contacto = ?, cli_estado = ?
                WHERE cli_nit = ?";

        /* Prepara */
        $stmt = $this->cn->prepare($sql);

        /* Valida */
        if (!$stmt) {
            return false;
        }

        /* Bind */
        $stmt->bind_param(
            "sssssss",
            $cli_razon_social,
            $cli_dir,
            $cli_tel,
            $cli_correo,
            $cli_nombre_contacto,
            $cli_estado,
            $cli_nit
        );

        /* Ejecuta */
        $ok = $stmt->execute();

        /* Cierra */
        $stmt->close();

        /* Retorna */
        return $ok;
    }

    /* Eliminar */
    public function delete($cli_nit)
    {
        /* Si no hay conexión */
        if ($this->cn === null) {
            return false;
        }

        /* SQL */
        $sql = "DELETE FROM cliente WHERE cli_nit = ?";

        /* Prepara */
        $stmt = $this->cn->prepare($sql);

        /* Valida */
        if (!$stmt) {
            return false;
        }

        /* Bind */
        $stmt->bind_param("s", $cli_nit);

        /* Ejecuta */
        $ok = $stmt->execute();

        /* Cierra */
        $stmt->close();

        /* Retorna */
        return $ok;
    }
}