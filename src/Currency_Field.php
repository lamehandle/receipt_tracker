<?php

namespace app;

class Currency_Field{

    public float $item_currency;
    public static array $error = [];


    public function __construct(float $number){
        self::get_errors($number);
        $this->item_currency = $number;
    }

        public function currency(): float{
        return $this->item_currency;
    }

    public function currency_string(): string
    {
        return "$". number_format($this->item_currency, 2, ".",",");
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
        return $this->item_currency === (float)$comparator;
    }

}