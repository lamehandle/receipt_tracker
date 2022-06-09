<?php

namespace app;
use PDO;
use DateTime;
use app\Taxes;
use app\Tax;
use app\Data_Rep;

class  Line_Item implements Purchase_Record {

    public Id $id;
    public Category $category;
    public String_Field $vendor;
    public String_Field $name;
    public Taxes $tax_rates;
    public Currency_Field $price;
    public String_Field $date;

    public function __construct(string $vendor, string $name, string $category, int $price, $date, array ...$tax_rate){
        $this->id = new Id('line-item_');
        $this->vendor = new String_Field($vendor);
        $this->name = new String_Field($name);
        $this->category = new Category($category);
        $this->price = new Currency_Field($price);
        $this->date = new String_Field($date); //A string representing a date in YYYY-MM-DD format, or empty
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

    public function vendor()  :String_Field  {
        return $this->vendor;
    }

    public function name() :String_Field   {
        return $this->name;
    }

    public function category()    {
        return $this->category;
    }


    public function date(): String_Field   {
        return $this->date;
    }

    public function set_tax_rates(array ...$tax_rate): void  {
        foreach ($tax_rate as $key => $value){
            $this->tax_rates->add_tax((new Tax($key, (int)$value)));
        }
    }

    public function sql_values() :Data_Rep  {
        $data = [
            'id'        => $this->id->id(),
            'vendor'    => $this->vendor->name(),
            'name'      => $this->name->name(),
            'category'  => $this->category->category(),
            'tax'       => $this->tax_rates->tax_amount($this),
            'price'     => $this->price->currency(),
            'date'      => $this->date()->name(),
            'sql'       => $this->sql_query()
        ];

        return (new Data_Rep("line_Item", $data));
    }

    public function sql_query() :string {
        return /** @lang text */
            "INSERT INTO line_Items ( id, vendor,  name,  category,  tax,  price,  date )
                            VALUES  (:id, :vendor, :name, :category, :tax, :price, :date)";
    }

    public function tax(): int {
        return $this->tax_rates->tax_amount($this);
    }
    public function tax_string(): string {
        return (string)$this->tax_rates->tax_amount($this);
    }

    public function subtotal()  : int  {
        return $this->price->currency();
    }

    public function total(): int{
       return $this->subtotal() + $this->tax();

    }

}
