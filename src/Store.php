<?php

namespace app;
use PDO;

interface Store
{
    public static function connect($dsn, $username, $password, $options) :PDO;
    public function __construct($host, $dbname, $username, $password, $port, $charset, $options = [] );
    public function retrieve_items($field, $value, Receipt $receipt = null) :Receipt;
    public function save_item(Line_Item $item);
    public function update_line_item( PDO $conn, Line_Item $item );
    public function delete_item(Line_Item $item);

}
