<?php

namespace app;

use DateTime;

class LineItemBuilder
{
    public array $user_data;
    public Line_Item $generated_item;

    public static function getUserData($user_data) : Line_Item
    {
        $id = uniqid("test_", false);
        $vendor = $user_data["vendor"];
        $item = $user_data["item"];
        $category = $user_data["category"];
        $tax_rates = $user_data["tax_rates"] ;
        $price = $user_data["price"];
        $date = $date = new DateTime();
        
        $new_item = new Line_Item($id, $vendor, $item, $category, $tax_rates, $price, $date);
        print_r($new_item); //did it build it?
        return $new_item;

    }

}