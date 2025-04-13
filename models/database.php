<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'prueba_db';
    private $user = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        if (!$this->conn) {
            try {
                $this->conn = new PDO(
                    "mysql:host=$this->host;dbname=$this->dbname;charset=utf8",
                    $this->user,
                    $this->password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die(" Error de conexión: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}
