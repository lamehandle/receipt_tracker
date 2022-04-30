<?php

namespace app;

class Taxes
{
    public static array $taxes;
    public array $rates;
    public function __construct()    {

    }

    public function add_tax(Tax ...$taxes): self    {
        //todo rewrite to take an array of values
        foreach ($taxes as $tax){
            $this->rates[] = $tax->rate;
        }
        return $this;
    }

    public function tax_amount(Line_Item $li): int{
        $price = $li->price->currency();
        return $tax_amount = array_reduce($this->rates, function($rate) use ($price){
            return $price * $rate->rates();
        },0);
    }



}