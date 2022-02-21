<?php

namespace app;

class Report
{
    public static function display_subtotal(Receipt $receipt):string{

      return number_format($receipt->subtotal(), 2, ".",",");
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