<?php

class Model 
{
    // > local

    // protected $table;
    // protected $host = "localhost";
    // protected $database = "db_hor";
    // protected $username = "root";
    // protected $password = "admin";

    // > Actual
    protected $table;
    protected $host = "localhost";
    protected $database = "db_hor";
    protected $username = "root";
    protected $password = "admin";

    protected $pdo;
    protected $stmt;
    protected $qry;

    public function __construct(){
        $this->connectActual();
    }

    public function connectActual(){
        
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=u286424252_serenidad_2023;charset=utf8","u286424252_root","SerenidadSuites2023");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function connect(){
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8","{$this->username}","{$this->password}");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function setTable($table){
        $this->table = $table;
        return $this ; //> for method chaining.
    }

    public function setQuery($qry){
        $this->qry = $qry;
        $this->stmt = $this->pdo->query($this->qry);
        return $this;
    }

    public function getAll(){
        try {
            return $this->stmt->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getFirst(){
        try {
            $data =  $this->stmt->fetch();
            return (object) $data; // convert to object
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Queries
    public function all(){
        $this->qry = "SELECT * FROM $this->table";
        $this->stmt = $this->pdo->query($this->qry);
        $data =  $this->getAll();
        return $data;
    }

    public function find($primaryKey){
        $data = $this->setQuery("SELECT * FROM $this->table WHERE id = $primaryKey")->getFirst();
        return  $data; 
    }

    public function getLastInsertedId(){
        $data = $this->setQuery("SELECT LAST_INSERT_ID() as id")->getFirst();
        return (int) $data->id;
    }


    
}
