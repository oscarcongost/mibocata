<?php
class Singleton{
    
    protected static $instance;
    private $pdo;

    private function __construct()
    {
        $host = 'localhost';
        $dbname = 'mibocata';
        $user = 'root';
        $password = '';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw $e; #revisar
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Singleton();
        }
        return self::$instance;
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function __clone() {}
    public function __wakeup(){}
}
