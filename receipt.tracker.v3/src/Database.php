<?php

namespace app;
use \PDO;

class Database
{
    public PDO $conn; // connection
    public string $host;
    public ?string $username;
    public ?string $password;
    public string $dbname;
    public ?string $charset;
    public ?string $dsn = 'mysql:host=$host; dbname=$dbname;port=8080;charset=utf8mb4'; //data source name
    public array $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        ];


    public function __construct($host, $username, $password, $dbname, $charset){
        $this->host = $host|'localhost';
        $this->username = $username|'root';
        $this->password = $password|'admin';
        $this->dbname = $dbname|'receipts_tracker';
        $this->charset = $charset|'utf8mb4';
     }


    public function connect(){
        try {
        $this->conn = new PDO($this->dsn, $this->username, $this->password, $this->options);

        } catch(\PDOException $e){
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }


    public function save_receipt(Receipt $receipt){
        $this->connect();


    }

    public function retrieve_receipt(){
        
    }

    public function update_line_item(){

    }
    
}