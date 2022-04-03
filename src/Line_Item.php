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
    public float $price;
    public DateTime $date;

    public function __construct(string $id, string $vendor, string $name, Category $category, $tax_rates, float $price, DateTime $date )
    {
        $this->id =  $id;
        $this->vendor = $vendor;
        $this->item = $name;
        $this->category = $category;
        $this->tax_rates = $tax_rates;
        $this->price = $price;
        $this->date = $date;
    }

    public static function from_post_data(array $data) : self
    {
        return new self($data["id"], $data["vendor"],$data["name"],$data["category"],$data["tax_rates"],$data["price"],$data["date"]);
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
