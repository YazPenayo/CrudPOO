<?php
class database {
    private $host;
    private $dbName;
    private $user;
    private $password;
    private $conn;

    public function __construct() {
        $this->host = getenv("MYSQL_SERVER");
        $this->dbName = getenv("MYSQL_DATABASE");
        $this->user = getenv("MYSQL_USER");
        $this->password = getenv("MYSQL_PASSWORD");
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->user, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}