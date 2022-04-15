<?php

namespace app;

class Report
{       //todo rework after new types are wired up
    public static function display_subtotal(Receipt $receipt):string{
        $prices = array_map(function($line_item){
            return $line_item->price->subtotal();
        }, $receipt::$line_items);

        $price_subtotal =  array_reduce($prices, callback: function($price):float{
           return $price->get_currency;
        }, initial: 0);

      return number_format($price_subtotal, 2, ".",",");
    }


    public static function display_taxes(Receipt $receipt):array {
        $taxes = $receipt->taxes();
        return array_map(function($tax){

             return number_format($tax,2,".",",");

             },$taxes);
    }

    public static function display_total(Receipt $receipt):string{
        return number_format($receipt->total(), 2,".", ",");
    }




}