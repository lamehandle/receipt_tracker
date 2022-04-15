<?php

namespace app;

use DateTime;

class LineItemFactory
{

    public static function getUserData($user_data) : Line_Item
    {

        $id = new Id_Field();
        $vendor = (new String_Field($user_data["vendor"] ?? ""));
        $name = (new String_Field($user_data["name"] ?? ""));
        $category = (new Category($user_data["category"])) ?? "";
        $tax_rates = $user_data["tax_rates"] ?? "";
        $price = $user_data["price"] ?? "";
        $date = $date = new DateTime();

        return new Line_Item($id, $vendor, $name, $category, $price, $date, $tax_rates);

    }

}