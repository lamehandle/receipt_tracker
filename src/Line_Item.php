<?php

namespace app;

use DateTime;

require_once "Category.php";

class  Line_Item implements Purchase_Record
{

    public string $id = "";
    public Category $category;
    public string $vendor = "";
    public string $item = "";
    public array $tax_rates = [];
    public float $price = 0;
    public DateTime $date;

    public function __construct($id, $vendor, $item, $category, $tax_rates, $price, $date )
    {
        $this->id =  $id;
        $this->vendor = $vendor;
        $this->item = $item;
        $this->category = new Category($category);
        $this->tax_rates = $tax_rates;
        $this->price = $price;
        $this->date = $date;
    }

    public function __get(string $name)
    {
        if(isset($this, $name)){
        return $this->$name;
        }else{
            return null;
        }
    }

    public function __set(string $name, $value): void
    {
        $this->$name = $value;
    }

    public function subtotal(): float{
        return $this->price;
    }

    public function total(): float{
        return $this->subtotal() + (float)array_sum($this->taxes());
    }

    public function taxes():array
    {
        return self::tax_values($this->tax_rates, $this->subtotal());
    }

    public static function tax_values(array $tax_rates, float $subtotal):array{
        return array_map(
            function ($tax_rate) use ($subtotal):float{
                return $tax_rate * $subtotal;
            },$tax_rates);
    }

}
