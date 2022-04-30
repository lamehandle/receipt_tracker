<?php

namespace app;

use DateTime;

class  Line_Item implements Purchase_Record {

    public Id_ $id;
    public Category $category;
    public String_Field $vendor;
    public String_Field $name;
    public Taxes $tax_rates;
    public Currency_Field $price;
    public DateTime $date;

    public function __construct(string $vendor, string $name, string $category, int $price, $date, array ...$tax_rate){
        $this->id = new Id_();
        $this->vendor = new String_Field($vendor);
        $this->name = new String_Field($name);
        $this->category = new Category($category);
        $this->price = new Currency_Field($price);
        $this->date = $date; //should be in datetime format from POST data
        $this->tax_rates = new Taxes();
            $this->set_tax_rates(...$tax_rate);
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

    public function set_tax_rates(array ...$tax_rate): void  {
       $keys = array_keys(...$tax_rate);
       $values = array_values(...$tax_rate);

       $all_tax = array_combine($keys, $values);
       $new_taxes = array_reduce($all_tax, function($tax){
       foreach ($tax as $key => $value){
            new Tax($key, $value);
        }
       }, []);

        $this->tax_rates->add_tax($new_taxes);
    }

    public function subtotal(): int{
        return $this->price->currency();
    }

    public function taxes(): int {
        return $this->tax_rates->tax_amount($this);
    }

    public function total(): int{
       return $this->subtotal() + $this->tax();

    }

}
