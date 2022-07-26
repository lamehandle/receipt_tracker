<?php

namespace app;
use Cassandra\Statement;
use PDO;
use PDOException;

require_once 'Store.php';

class Database_Store implements Store
{
    public    PDO   $connection; // connection
    public string   $host;
    public string   $dbname;
    public string   $port;
    public string   $charset;
    public string   $username;
    public string   $password;
    public string   $dsn; //data source name
    public  array   $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //always throw exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //retrieve records as associative arrays
        PDO::ATTR_EMULATE_PREPARES   => false, //do not use emulate mode
        ];

    public function __construct($host = '', $dbname = '', $port = '', $charset = '', $username = '', $password = ''){

        $this->host     = $host     | 'localhost';
        $this->dbname   = $dbname   | 'receipts_tracker';
        $this->port     = $port     | '3306';
        $this->charset  = $charset  | 'utf8mb4';
        $this->username = $username | 'root';
        $this->password = $password | 'root';
        $this->dsn      = "mysql:host=$host;dbname=$dbname;port=$port;charset=$charset";

     }

    public function connect($dsn = "",$username = "",$password = "",$options = []):PDO {
        try {
        echo "Connection Successful." . PHP_EOL;
        return $this->connection = new PDO($this->dsn,$this->username,$this->password,$this->options);

        } catch(PDOException $e){
            echo "Connection failed " . $e.getMessage();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }


    }

    public function insert_records( Receipt $receipt ) {
          try{
              $data = $receipt->create_sql();
              $connection= $this->connect();
              array_map(function($item) use ($connection) {
                  $data = $item->data();
                  $Statement = $connection->prepare($data['sql']);
                  $Statement->execute([
                      $data['id'],
                      $data["vendor"],
                      $data["item"],
                      $data["category"],
                      $data["price"],
                      $data['gst'],
                      $data['pst'],
                      $data["date"]
                      ]);

              }, $data);

          }catch(PDOException $e){
              echo $e->getMessage();
          }
          $connection = null;
          echo "Connection Closed.";
    }

     public function retrieve_records(Receipt $receipt, string $sql )  { //todo implement retrieve_records
        try {
            $connection = $this->connect();
            $statement  = $connection->query($sql); //PDO statement object
            print_r("Statement consists of the following:". PHP_EOL);

            //need to pull data out.
            while (($record = $statement->fetch(PDO::FETCH_NAMED)) !== false) {
               $receipt->line_items[] = new Line_Item($record['vendor'], $record['name'], $record['category'],
                   $record['price'], $record['gst'], $record['pst'], $record['date']);
            }
            print_r($receipt->line_items);

        } catch(PDOException $e){
            echo $e->getMessage();

        }
        $connection = null;
    }




    public function update_record(){ //todo implement update_record


    }

    public function delete_record(){//todo implement delete_record

    }



}