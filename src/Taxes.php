<?php

namespace app;

class Taxes
{
    public static array $taxes;
    public array $rate;
    public function __construct()    {

    }

    public function add_tax(Tax ...$taxes): self    {
        //todo rewrite to take an array of values
        foreach ($taxes as $tax){
            $this->rate[] = $tax;
        }
        return $this;
    }

    public static function combine_tax_amounts(Tax ...$tax):array  {
        //get tax key names
        $tax_keys = array_walk_recursive($tax->rates(), 'array_keys');
        //get tax values
        $tax_values = array_walk_recursive( $tax->rates(), 'array_values');
        //combine multiple arrays if provided.
        return self::$taxes = array_combine($tax_keys, $tax_values);
    }

    public static function tax_amounts(Line_Item $li)    {
        $tax_arr = self::combine_tax_amounts($li->tax_rates());
        $tax_amounts = static::$taxes = array_map(function($value) use ($li){
            return $value * $li->subtotal();

        }, $tax_arr);
    }

}