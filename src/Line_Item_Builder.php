<?php

namespace app;

use DateTime;

class LineItemBuilder
{
    public array $user_data;
    public ?array $errors = [];


    public static function getUserData($user_data) : Line_Item
    {
        $errors[] = LineItemBuilder::validate_data($user_data);

        $id = uniqid("test_", false);
        $vendor = $user_data["vendor"];
        $item = $user_data["item"];
        $category = $user_data["category"];
        $tax_rates = $user_data["tax_rates"] ;
        $price = $user_data["price"];
        $date = $date = new DateTime();

        $new_item = new Line_Item($id, $vendor, $item, $category, $tax_rates, $price, $date);

//        print_r($new_item); //did it build it?

        return $new_item;
    }

    public static function validate_data($user_data) : array
    {   $errors = [];
        if(!$user_data) {
            $errors[] = "line item is empty";
        }

        if( !is_string($user_data["vendor"])){
            $errors[] = "line item is empty";
        }
        if( !is_string($user_data["item"])){
            $errors[] = "line item is name must be a string";
        }
        if( !is_string(($user_data["category"]))){
            $errors[] = "line item is name must be a string";
        }
        if( !is_array($user_data["tax_rates"])){
            $errors[] = "line item is empty";
        }
        if( !is_float($user_data["price"])){
            $errors[] = "line item is empty";
        }

        return $errors;
    }

}