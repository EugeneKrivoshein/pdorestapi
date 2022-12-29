<?php

class Database
{
    //db params
    private $host = 'localhost';
    private $db_name = 'crudbd';
    private $username = 'root';
    private $pass = '';
    private $connect;

    //db connect
    public function connect()
    {
        $this->connect = null;

        try {
            $this->connect = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->pass);
        } catch (PDOException $e) {
            echo 'connect error: ' . $e->getMessage();
        }
        return $this->connect;
    }
}
