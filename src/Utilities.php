<?php

namespace app;

class Utilities
{
    public static function printData($data){
        echo "<pre>";
        print_r($data); //echo for testing
        echo "</pre>";
        echo "<br>";

    }

    public static function randomSalt():string{
        $str = '';
        $char = "abcdefghijklmnopqrstuvwxyz1234567890";
        for ($i = 0; $i < 5; $i++) {
            $str[$i] = rand($char[0], $char[strlen($char)]);
        }
       return $str;
    }

    public static function random_price(): int{
        //I want the format in cents
        $dollars = mt_rand(0, 500);
        $tens = mt_rand(0, 9)/10;
        $ones = mt_rand(0, 9)/100;

        return $dollars + $tens + $ones;
    }
    public static function sum_map(array $items, string $method) {
        return array_sum(
            array_map(
                function(LineItem $i) use ($method){
                    return call_user_func([$i, $method]);
                }
                ,$items)
            );
    }

    public static function pluck(array $array, string $field ){
        return array_map(function($array) use ($field){
                return $array[$field];
        }, $array);
    }

}