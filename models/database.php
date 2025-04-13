<?php

class Database {
    public static function connect() {
        $host = 'localhost';
        $database = 'prueba_db';
        $user = 'root';
        $password = '';

        try {
            $conexion = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            die("Error al conectar " . $e->getMessage());
        }
    }
}

Database::connect();
