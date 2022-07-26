<?php

class Database
{
    private $host = "localhost";
    private $db_name = "shrturl";
    private $username = "root";
    private $password = "root";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch(PDOException $exception) {
            echo "Ошибка соединения: " . $exception->getMessage();
        }

        return $this->conn;
    }

    public function select($query = "")
    {
        $conn = $this->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectOne($query = "")
    {
        $conn = $this->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($query = "",$values=[])
    {
        $conn = $this->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute($values);
    }
}