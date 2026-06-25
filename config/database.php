<?php

class Database {
    private $host = "localhost";
    private $port = "5432";
    private $db_name = "db_super_casas";
    private $username = "postgres";
    private $password = "admin";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
        return $this->conn;
    }
}
?>