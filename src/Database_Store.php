<?php

namespace app;
use PDO;
use PDOException;

require_once 'Store.php';

class Database_Store implements Store
{
    public  PDO     $connection; // connection
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

    public function insert_records(Receipt $receipt ) {
          try{
              $data = $receipt->create_sql();
              $connection= $this->connect();
              array_map(function($item) use ($connection) {
                  $data = $item->data();
                  $Statement = $connection->prepare($data['sql']);
                  $Statement->execute([
                          $data['id'],
                          $data['vendor'],
                          $data['name'],
                          $data['category'],
                          $data['tax'],
                          $data['price'],
                          $data['date']
                      ]);
              }, $data);



          }catch(PDOException $e){
              echo $e->getMessage();
          }
          $connection = null;
    }


    public function retrieve_items($field, $value, Receipt $receipt = null) :Receipt { //todo refactor to be more specific?
        try {


            $conn = Database_Store::connect($this->dsn,$this->username,$this->password,$this->options);
            if($receipt = null){
                $receipt = new Receipt(uniqid("", false));
            }
            $sql = /** @lang text */
                "SELECT * FROM receipts_2021 WHERE :field = :value";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                    ':field'=> $field,
                    ':value'=>$value
                ]);
            foreach ($stmt as $record){
                $receipt->addItem($record);
              }
        } catch(PDOException $e){
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
        return $receipt;
    }


    public function update_line_item(PDO $conn, Line_Item $item ){
        try {
            //connect to db
            $conn = Database_Store::connect($this->dsn, $this->username, $this->password, $this->options);

            //create and store the query you want to be able to run.
            $sql = /** @lang text */
                'UPDATE receipts_2021    
                SET vendor     = :vendor    AND 
                    item       = :item      AND 
                    category   = :category  AND
                    price      = :price     AND
                    date       = :date
                WHERE :id = id';
            //prepare the sql query. This step prevents injection attacks.
        $stmt = $conn->prepare($sql);
            //bind values so that you can dynamically swap variables into the SQL query
        $stmt->bindValue(':id',         $item->id);
        $stmt->bindValue(':vendor',     $item->vendor);
        $stmt->bindValue(':item',       $item->name);
        $stmt->bindValue(':category',   $item->category);
        $stmt->bindValue(':price',      $item->price);
        $stmt->bindValue(':date',       $item->date);

        } catch(PDOException $e){
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
        $conn = null; //close connection
    }

    public function delete_item(Line_Item $item){
        try {
            //connect to db
            $connection= $this->connect();

            $sql = /** @lang text */
                "Delete FROM receipts_2021 
                 WHERE :id = id";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $item->id);
            $stmt->execute();

        } catch(PDOException $e){
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
        $connection = null;

    }
//todo this is overly complex and I am simplifying


}