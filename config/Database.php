<?php
namespace Config;

use PDO;
use PDOException;

class Database {
    private static $host = 'localhost';
    private static $db_name = 'youdemy_db';
    private static $username = 'root';
    private static $password = '';
    private static $pdo;

    public static function makeconnection() {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=' . self::$host . ';dbname=' . self::$db_name,
                    self::$username,
                    self::$password
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return self::$pdo;
    }


    
}