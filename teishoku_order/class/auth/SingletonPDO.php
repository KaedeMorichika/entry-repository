<?php
namespace auth;

use http\Exception\RuntimeException;

class SingletonPDO
{
    private static $dbh;

    private static $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

    private function __construct()
    {
        if (empty(self::$dbh)) {
            try {
                self::$dbh = new \PDO(self::$dsn, DB_USER);
            } catch (\PDOException $e) {
                echo 'DB Connection failed:' . $e->getMessage();
            }
        }
    }

    public static function connect()
    {
        if (empty(self::$dbh)) {
            $pdo = new SingletonPDO();
        }

        return self::$dbh;
    }

    private function getDBH()
    {
        return self::$dbh;
    }

    public final function __clone()
    {
        throw new RuntimeException('Clone is not allowed against ' . get_class($this));
    }
}