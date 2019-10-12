<?php

/*$host = 'localhost';
$user = 'nico';
$password = 'scogar';
$dbname = 'inge';

$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

$pdo = new PDO($dsn, $user, $password);

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->exec("set names utf8");*/

class Connection {

    private static $conn = null;

    private $connection = null;

    private function __construct() {
        $host = 'localhost';
        $user = 'nico';
        $password = 'scogar';
        $dbname = 'inge';

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

            // Modo excepción
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Codificación UTF8
            $this->connection->exec("set names utf8");

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public static function getConnection() {
        if (self::$conn === null) {
            self::$conn = new self();
        }
        return self::$conn->connection;
    }

}