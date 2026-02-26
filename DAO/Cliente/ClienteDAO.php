<?php
include_once '../Lib/Config/conexionSqli.php';

class ClienteDAO extends Connection {

    private static $instance = NULL;

    public static function getInstance(): ClienteDAO {
        if (self::$instance == NULL) {
            self::$instance = new ClienteDAO();
        }
        return self::$instance;
    }

    public function getAll() {
        $sql = "SELECT * FROM cliente";
        return $this->execute($sql);
    }

    public function getByNit($cli_nit) {
        $sql = "SELECT * FROM cliente WHERE cli_nit = '$cli_nit'";
        return $this->execute($sql);
    }
}