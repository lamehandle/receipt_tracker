<?php

namespace app;

class Taxes
{
    public static array $taxes;
    public array $rates;
    public function __construct()    {

    }

    public function add_tax(Tax ...$taxes): self    {
        foreach ($taxes as $tax){
            $this->rates[] = $tax->rate;
        }
        return $this;
    }

    public function tax_amount(Line_Item $li): int{
        $price = $li->price->currency();
            return array_reduce($this->rates, function($rate) use ($price){
            return $price * $rate;
        },0);
    }



}