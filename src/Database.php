<?php

namespace app;
use PDO;
use PDOException;

class Database
{
    public PDO      $conn; // connection
    public string   $host;
    public string   $username;
    public string   $password;
    public string   $dbname;
    public string   $charset;
    public string   $dsn = 'mysql:host=$host; dbname=$dbname;port=8080;charset=$charset'; //data source name
    public array    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES   => false,
        ];


    public function __construct($host, $username, $password, $dbname, $charset){

        $this->host     = $host     | 'localhost';
        $this->username = $username | 'root';
        $this->password = $password | 'admin';
        $this->dbname   = $dbname   | 'receipts_tracker';
        $this->charset  = $charset  | 'utf8mb4';
     }


    public function connect() :PDO{
        try {
        $conn = new PDO($this->dsn, $this->username, $this->password, $this->options);

        } catch(PDOException $e){
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $conn;
    }

    public function retrieve_receipt(Receipt $receipt, $field, $value) :Receipt{ //todo refactor to be more specific?
        $this->connect();
        $sql = "SELECT * FROM receipts_2021 WHERE :field = :value";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
                'field'=> $field,
                'value'=>$value
            ]);
        foreach ($stmt as $record){
            //add each row to receipt
              $receipt->addItem($record);
          }
        return $receipt;
    }

    public function save_receipt(Receipt $receipt){

    }


    public function update_line_item($id, $field, $value){
        $this->connect();
        $sql = 'UPDATE receipts_2021 
                SET :field = :value 
                WHERE :id = $id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
                'field'=> $field,
                'value'=>$value
            ]);



    }
    
}