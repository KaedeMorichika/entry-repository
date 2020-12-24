<?php
namespace SingletonPDO;

use http\Exception\RuntimeException;

class SingletonPDO
{
    private const $dsn;

    private function __construct()
    {

    }

    public static function connect()
    {
        
    }

    public final function __clone()
    {
        throw new RuntimeException('Clone is not allowed against ' . get_class($this));
    }
}