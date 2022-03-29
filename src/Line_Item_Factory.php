<?php

namespace app;

use DateTime;

class LineItemFactory
{
    public array $user_data;
    public ?array $errors = [];


    public static function getUserData($user_data) : Line_Item
    {
        $errors[] = LineItemFactory::validate_data($user_data);

        $id = uniqid("item_", false);
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
            $errors[] = "item vendor must be a string";
        }
        if( !is_string($user_data["item"])){
            $errors[] = "item name must be a string";
        }
        if( !is_string(($user_data["category"]))){
            $errors[] = "category must be a string";
        }
        if( !is_float((float)$user_data["tax_rates"])){
            $errors[] = "tax is not correct type";
        }
        if( !is_float((float)$user_data["price"])){
            $errors[] = "price is not correct type";
        }

        return $errors;
    }

}