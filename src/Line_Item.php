<?php

namespace app;
use DateTime;

class  Line_Item implements Purchase_Record {

    public Id $id;
    public Vendor $vendor;
    public Item $item;
    public Category $category;
    public Price $price;
    public DateTime $date;
    public GST $gst;
    public PST $pst;

    public function __construct(string $vendor, string $item, string $category, int $price, int $gst, int $pst, string $date){

        $this->id = new Id('line-item_');
        $this->vendor = new Vendor($vendor);
        $this->item = new Item($item);
        $this->category = new Category($category);
        $this->price = new Price($price);
        $this->gst = new GST( $gst );
        $this->pst = new PST( $pst );
        $this->date = date_create($date); //A string representing a date in YYYY-MM-DD format, or empty
    }

    public static function from_post_data(array $data) : self {
        return new self (
            $data['vendor'],
            $data['item'],
            $data['category'],
            $data['price'],
            $data['gst'],
            $data['pst'],
            $data['date']
        );
    }

    public function vendor(): string  {
        return $this->vendor->name();
    }

    public function item(): string   {
        return $this->item->name();
    }

    public function category(): string    {
        return $this->category->name();
    }

        //todo rework to use an actual date object
    public function date(): DateTime   {
        return $this->date;
    }

    public function tax():  int {
        return $this->gst->rate() + $this->pst->rate();
    }

    public function tax_string():   string    {
        return number_format( ( $this->total() - $this->subtotal() ), 2,'.',',' );
    }

    public function subtotal() : int  {
        return $this->price->amount();
    }

    public function total(): int{
      return $this->subtotal() + ( $this->subtotal() * $this->tax() );
    }

    public function sql_query() :string {
        return "INSERT INTO line_Items  ( id,  vendor,  item,  category,  price,   gst,  pst,  date )
                            VALUES      (:id, :vendor, :item, :category, :price,  :gst, :pst, :date )";
    }


    public function sql_values() :Data_Rep  {
        $data = [
            'id'        => $this->id->id(),
            'vendor'    => $this->vendor->name(),
            'item'      => $this->item->name(),
            'category'  => $this->category->name(),
            'price'     => $this->price->amount(),
            'gst'       => $this->gst->rate(),
            'pst'       => $this->pst->rate(),
            'date'      => $this->date->format('Y-m-d H:i:s'), //rework as DateTime
            'sql'       => $this->sql_query(),
        ];

        return (new Data_Rep($data));
    }

}
