<?php

namespace App\Core;

class Model
{

    private static $connection;

    public static function getConnection()
    {

        if (!isset(self::$connection)) {
            self::$connection = new \PDO("mysql:host=localhost;port=3306;dbname=user;", "root", "12345678");
        }

        return self::$connection;
    }
}
