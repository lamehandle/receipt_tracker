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
    public ?string $dsn = 'mysql:host=$host; dbname=$dbname'; //data source name
    public array $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];


    public function __construct($host, $username, $password, $dbname){
        $this->host = $host|'localhost';
        $this->username = $username|'root';
        $this->password = $password|'admin';
        $this->dbname = $dbname|'receipts_tracker';

     }


    public function connect(){
        try {
        $this->conn = new PDO($this->dsn, $this->username, $this->password, $this->options);

        } catch(\PDOException $e){
            die($e->getMessage());
        }


    }


    public function save_receipt(Receipt $receipt){

    }

    public function retrieve_receipt(){
        
    }

    public function update_line_item(){

    }
    
}