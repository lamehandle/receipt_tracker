<?php

namespace app;

class Tax_Field
{
    private array $tax_rates = [];
    public static array $error = [];

    public function __construct(array ...$tax_rate){

        $this->tax_rates[] = $tax_rate;
    }

    public function get_rates(): array
    {
        return $this->tax_rates;
    }

    public function is_equal($rate, $comparator):bool{
        return $this->tax_rates[$rate] === $comparator;
   }

    public function display_tax_rates():array {
        array_map(function($rate){
            return number_format($rate, 2,".", ",");
        },
        $this->tax_rates);
        return $this->tax_rates;
    }

    public static function get_errors(array $tax_rates):array{
        if (isEmpty($tax_rates)) {
            $error[] = "No rates available.";
        }
        self::$error[] = "";
        return self::$error;
    }
}