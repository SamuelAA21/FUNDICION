<?php

class Connection
{
    private $host;
    private $user;
    private $password;
    private $port;
    private $database;
    private $link;

    public function __construct()
    {
        $this->setConnect();
        $this->connect();
    }

    private function setConnect()
    {
        require __DIR__ . '/configuracion.php';
        $this->host = defined('DB_HOST') ? DB_HOST : ($servidor ?? 'localhost');
        $this->user = defined('DB_USER') ? DB_USER : ($usuario ?? 'root');
        $this->password = defined('DB_PASSWORD') ? DB_PASSWORD : ($clave ?? '');
        $this->port = defined('DB_PORT') ? DB_PORT : ($puerto ?? 3306);
        $this->database = defined('DB_DATABASE') ? DB_DATABASE : ($baseDatos ?? 'bd_fundicion');
    }

    private function connect()
    {
        $this->link = mysqli_connect(
            $this->host,
            $this->user,
            $this->password,
            $this->database,
            $this->port
        );

        if (!$this->link) {
            throw new RuntimeException('No fue posible conectar con la base de datos.');
        }

        mysqli_set_charset($this->link, 'utf8mb4');
    }

    public function closeConnect()
    {
        if ($this->link instanceof mysqli) {
            mysqli_close($this->link);
        }
    }

    public function getConnect()
    {
        return $this->link;
    }

    protected function fetchAll(string $sql, string $types = '', array $params = []): array
    {
        $statement = $this->prepareAndExecute($sql, $types, $params);
        $result = mysqli_stmt_get_result($statement);
        $rows = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
        mysqli_stmt_close($statement);
        return $rows;
    }

    protected function fetchOne(string $sql, string $types = '', array $params = []): ?array
    {
        $rows = $this->fetchAll($sql, $types, $params);
        return $rows[0] ?? null;
    }

    protected function executeStatement(string $sql, string $types = '', array $params = []): bool
    {
        $statement = $this->prepareAndExecute($sql, $types, $params);
        $ok = mysqli_stmt_affected_rows($statement) >= 0;
        mysqli_stmt_close($statement);
        return $ok;
    }

    protected function executeInTransaction(callable $callback): bool
    {
        mysqli_begin_transaction($this->link);

        try {
            $result = (bool)$callback($this);
            if ($result) {
                mysqli_commit($this->link);
                return true;
            }

            mysqli_rollback($this->link);
            return false;
        } catch (Throwable $exception) {
            mysqli_rollback($this->link);
            throw $exception;
        }
    }

    private function prepareAndExecute(string $sql, string $types = '', array $params = []): mysqli_stmt
    {
        $statement = mysqli_prepare($this->link, $sql);

        if (!$statement) {
            throw new RuntimeException('No fue posible preparar la consulta.');
        }

        if ($types !== '' && $params !== []) {
            $this->bindParams($statement, $types, $params);
        }

        if (!mysqli_stmt_execute($statement)) {
            $message = mysqli_stmt_error($statement);
            mysqli_stmt_close($statement);
            throw new RuntimeException('Error al ejecutar la consulta: ' . $message);
        }

        return $statement;
    }

    private function bindParams(mysqli_stmt $statement, string $types, array $params): void
    {
        $references = [];
        foreach ($params as $index => $value) {
            $references[$index] = &$params[$index];
        }

        array_unshift($references, $types);
        mysqli_stmt_bind_param($statement, ...$references);
    }
}
