<?php

namespace app;

class Currency_Field{

    private float $line_item_currency;
    public static array $error = [];

    public function __construct($number){ //Does $_POST data even have numeric values?
        self::get_errors($number);
        $this->line_item_currency = (float)$number;
    }

    public static function get_errors($number):array{
        if (isEmpty($number)) {
            $error[] = "No number entered.";
        }elseif(!is_numeric($number)){
            $error[] = "Must be a number.";
        }
        self::$error[] = "";
        return self::$error;
    }

    public function is_equal($comparator):bool{
        return $this->line_item_currency === (float)$comparator;
    }

    public function display_currency():string {
        return number_format($this->line_item_currency, 2,".", ",");
    }
}