<?php
class DB
{
    private $host = "127.0.0.1";
    private $database_name = "api_rest";
    private $login = "root";
    private $root  = "root";
    public  $pdo;


    public function getConnection()

    {
        $this->pdo = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->database_name, $this->login, $this->root);
        $this->pdo->exec('SET NAMES utf8');
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        return $this->pdo;
    }

    /*
    public function get_all()
    {
        $req = $this->pdo->query("SELECT *  FROM produits");
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;

    }*/
}
