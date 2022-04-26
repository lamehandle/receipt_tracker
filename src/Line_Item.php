<?php

namespace app;

use DateTime;


class  Line_Item implements Purchase_Record {

    public Id_ $id;
    public Category $category;
    public String_Field $vendor;
    public String_Field $name;
    public Tax $tax_rates;
    public Currency_Field $price;
    public DateTime $date;

    public function __construct(string $vendor, string $name, string $category, float $price, $date, array $tax_rates){
        $this->id = new Id_();
        $this->vendor = new String_Field($vendor);
        $this->name = new String_Field($name);
        $this->category = new Category($category);
        $this->price = new Currency_Field($price);
        $this->date = $date; //should be in datetime format from POST data
        $this->tax_rates =  new Tax($tax_rates); //todo rewrite to take an array of values
    }

    public static function from_post_data(array $data) : self {
        return new self (
            $data["vendor"],
            $data["name"],
            $data["category"],
            $data["price"],
            $data["date"],
            $data["tax_rates"]
        );
    }

    public function __set(string $name, $value): void {
        $this->$name = $value;
    }

    public function vendor()    {
        return $this->vendor();
    }

    public function name()    {
        return $this->name();
    }

    public function category()    {
        return $this->category();
    }

    public function price()    {
        return $this->price();
    }

    public function date()    {
        return $this->date();
    }

    public function taxes(): Taxes    {
        return $this->tax_rates;
    }

    public function subtotal(): float{
        return $this->price->currency();
    }

    public function total(): float{
        return array_reduce(Taxes::tax_amounts($this), function($tax_amount){
            return $this->subtotal() + $tax_amount;
        },0.00);
    }

}
