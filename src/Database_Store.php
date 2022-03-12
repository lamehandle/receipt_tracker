<?php

namespace app;
use PDO;
use PDOException;

require_once 'Store.php';

class Database_Store implements Store
{
    public PDO      $conn; // connection
    public string   $host;
    public string   $dbname;
    public string   $port;
    public string   $charset;
    public string   $username;
    public string   $password;
    public string   $dsn; //data source name
    public array    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //always throw exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //retrieve records as associative arrays
        PDO::ATTR_EMULATE_PREPARES   => false, //do not use emulate mode
        ];

    public function __construct($host = '', $dbname = '', $port = '', $charset = '', $username = '', $password = '',  $options = [] ){

        $this->host     = 'localhost';
        $this->dbname   = 'receipts_tracker';
        $this->port     = '80';
        $this->charset  = 'utf8mb4';
        $this->username = 'root';
        $this->password = 'admin';
        $this->options  = $options;
        $this->dsn      = "mysql:host=$this->host;dbname=$this->dbname;port=$this->port;charset=$this->charset;";

     }

//     /**
//        *@param string $username
//     **/
//    public function setUsername(string $username): void
//    {
//        $this->username = $username;
//    }
//
//    /**
//        *@param string $dbname
//    **/
//    public function setDbname(string $dbname): void
//    {
//        $this->dbname = $dbname;
//    }
//
//    /**
//     * @param string $host
//     **/
//    public function setHost(string $host): void
//    {
//        $this->host = $host;
//    }

    public static function connect($dsn, $username, $password, $options) :PDO{
        try {
        $conn = new PDO($dsn, $username, $password, $options = []);

        } catch(PDOException $e){
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $conn;
    }

    public function retrieve_items($field, $value, Receipt $receipt = null) :Receipt { //todo refactor to be more specific?
        try {
            $conn = Database_Store::connect($this->dsn, $this->username, $this->password, $this->options);
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

    public function save_item(Line_Item $item){
        try {
            $conn = Database_Store::connect($this->dsn, $this->username, $this->password, $this->options);
            $sql = /** @lang text */
                "INSERT INTO receipts_2021 (id, vendor, item, category, subtotal, tax, total, date)
                 VALUES (:id, :vendor, :item, :category, :subtotal, :tax, :total, :date)";
            $conn->prepare($sql)->execute([
                'id'        => $item->id,
                'vendor'    => $item->vendor,
                'item'      => $item->item,
                'category'  => $item->category,
                'subtotal'  => $item->subtotal(),
                'total'     => $item->total(),
                'date'      => $item->date
            ]);
        } catch(PDOException $e){
            throw new PDOException($e->getMessage(), (int)$e->getCode());

        }
        $conn = null;
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
        $stmt->bindValue(':item',       $item->item);
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
            $conn = Database_Store::connect($this->dsn, $this->username, $this->password, $this->options);

            $sql = /** @lang text */
                "Delete FROM receipts_2021 
                 WHERE :id = id";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $item->id);
            $stmt->execute();

        } catch(PDOException $e){
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
        $conn = null;

    }


}