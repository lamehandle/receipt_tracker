<?php

namespace app;
use PDO;

interface Store
{
    public function __construct( $host = '', $dbname = '', $port = '', $charset = '', $username = '', $password = '' );
    public function connect( $dsn, $username, $password, $options ): PDO;
    public function insert_records( Receipt $receipt );
    public function update_record(  );
    public function retrieve_records(Receipt $receipt, string $value  );
    public function delete_record(  );

}