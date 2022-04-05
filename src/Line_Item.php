<?php

namespace app;

use DateTime;

class  Line_Item implements Purchase_Record
{

    public Id_Field $id;
    public Category $category;
    public String_Field $vendor;
    public String_Field $item;
    public Tax_Field $tax_rates;
    public Currency_Field $price;
    public DateTime $date;

    public function __construct(Id_Field $id, String_Field $vendor, String_Field $name, Category $category, Currency_Field $price, DateTime $date, Tax_Field $tax_rates ){
        $this->id =  $id;
        $this->vendor = $vendor;
        $this->item = $name;
        $this->category = $category;
        $this->price = $price;
        $this->date = $date;
        $this->tax_rates = $tax_rates;
    }

    public static function from_post_data(array $data) : self {
        return new self((new Id_Field($data["id"])),
            (new String_Field($data["vendor"])),
            (new String_Field($data["name"])),
            (new Category($data["category"])),
            (new Currency_Field($data["price"])),
            $data["date"],
            (new Tax_Field(...$data["tax_rates"])));
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

    public function subtotal(): Currency_Field{
        return $this->price;
    }

    public function total(): Currency_Field{
         $this->subtotal() + array_sum($this->taxes());
    }

    public function taxes():array
    {
        return self::tax_values($this->tax_rates, $this->subtotal());
    }

    public static function tax_values(Tax_Field $tax_rates, Currency_Field $subtotal): array{
        return array_map(
            function ($tax_rate) use ($subtotal):float{
                return $tax_rate * $subtotal;
            },$tax_rates->get_rates());
    }

}
