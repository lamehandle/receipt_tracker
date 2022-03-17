<?php

namespace app;
use PDO;

interface Store
{
    public function __construct($host = '', $dbname = '', $port = '', $charset = '', $username = '', $password = '');
    public static function connect($dsn, $username, $password, $options);
    public function retrieve_items($field, $value, Receipt $receipt = null);
    public function save_item(Line_Item $item);
    public function update_line_item(PDO $conn, Line_Item $item );
    public function delete_item(Line_Item $item);

}