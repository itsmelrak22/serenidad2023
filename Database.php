<?php
Class Database{
    private $dbName;
    private $dbHost;
    private $dbUsername;
    private $dbPassword;
    
    private $pdo;
    private $stmt;
    private $qry;
    private $tbl_name;


    public function __construct($name, $host, $user, $password){
        $this->dbName = $name;
        $this->dbHost = $host;
        $this->dbUsername = $user;
        $this->dbPassword = $password;
        
    }

    public function connect(){
        try {
            
            $this->pdo = new PDO("mysql:host={$this->dbHost};dbname={$this->dbName};charset=utf8","{$this->dbUsername}","{$this->dbPassword}");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            //throw $th;
            echo $e->getMessage();
        }
    }


    public function executeStmt(){
        try {
            $this->stmt = $this->pdo->query($this->qry);
            return $this->stmt->fetchAll();
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function executeOneStmt(){
        try {
            $this->stmt = $this->pdo->query($this->qry);
            return $this->stmt->fetch();
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function setTable($tbl_name){
        $this->tbl_name = $tbl_name;
    }

    public function setQry($qry){
        $this->qry = $qry;
    }

    
    // Queries
    public function all(){
        $this->qry = "SELECT * FROM $this->tbl_name";
        $data =  $this->executeStmt();
        return $data;
    }


}