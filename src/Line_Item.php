<?php

namespace app;

use DateTime;

class  Line_Item implements Purchase_Record
{

    public Id_Field $id;
    public Category $category;
    public String_Field $vendor;
    public String_Field $name;
    public Tax_Field $tax_rates;
    public Currency_Field $price;
    public DateTime $date;

    public function __construct(string $vendor, string $name, string $category, $price,  $date, array $tax_rates ){
        $this->id =  (new Id_Field());
        $this->vendor = (new String_Field($vendor));
        $this->name = (new String_Field($name));
        $this->category = (new Category($category));
        $this->price = (new Currency_Field($price));
        $this->date = $date;
        $this->tax_rates =  $tax_rates;
    }

    public static function from_post_data(array $data) : self {
        return new self (
            (new String_Field($data["vendor"])),
            (new String_Field($data["name"])),
            (new Category($data["category"])),
            (new Currency_Field($data["price"])),
            $data["date"],
            $data["tax_rates"]
        );
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
         return $this->subtotal() + (new Currency_Field(array_sum($this->taxes())));
    }

    public function taxes():array
    {
        return self::tax_values($this->tax_rates, $this->subtotal());
    }

    public static function tax_values(Tax_Field $tax_rates, Currency_Field $subtotal): array{
        return array_map(
            function ($tax_rate) use ($subtotal):Currency_Field{
                return (new Currency_Field($tax_rate * $subtotal));
            },$tax_rates->get_rates());
    }

}
