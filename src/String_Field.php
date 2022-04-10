<?php

namespace app;
class String_Field{

    private string $line_item_string;
    public static array $error = [];

    public function __construct($data){
        self::get_errors($data);
        $this->line_item_string = $data;
    }

    public static function get_errors($data){
        if (empty($data)) {
            self::$error[] = "No data entered.";
        }elseif(!is_string($data)){
            self::$error[] = "Must be non-numeric input.";
        }
        self::$error[] = "";

    }

    public function is_equal(string $comparator):bool{
        return $this->line_item_string === $comparator;
    }
}