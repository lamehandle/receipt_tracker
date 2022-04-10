<?php

namespace app;

class Currency_Field{

    private float $line_item_currency;
    public static array $error = [];

    public function __construct($number){
        self::get_errors($number);
        $this->line_item_currency = $number;
    }

    public static function get_errors($number):array{
        if (empty($number)) {
            self::$error[] = "No number entered.";
        }elseif(!is_numeric($number)){
            self::$error[] = "Must be a number.";
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