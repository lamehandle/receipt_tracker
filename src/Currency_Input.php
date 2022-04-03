<?php

namespace app;

class Currency_Input
{
    private float $line_item_currency;
    public static array $error = [];

    public function __construct(float $number){
        self::get_errors($number);
        $this->line_item_currency = $number;
    }
    public static function get_errors($number) : array{
        if (isEmpty($number)) {
            $error[] = "No number entered.";
        }elseif(!is_string($number)){
            $error[] = "Must be a number.";
        }
        self::$error[] = "";
        return self::$error;

    }

    public function is_equal(float $comparator):bool{
        return $this->line_item_currency === (float)$comparator;
    }

    public function display_currency()
    {
        return number_format($this->line_item_currency, 2,".", ",");
    }

}