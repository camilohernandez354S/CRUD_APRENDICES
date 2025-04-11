<?php
$host = 'localhost';
$database = 'prueba_db';
$user = 'root';
$password = '';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión establecida";
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
