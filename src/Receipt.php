<?php

namespace app;


use PDO;

class Receipt implements Purchase_Record
{
    public array $line_items = [];

    private Id $id;

    public function __construct(string $id){
        if (empty($id) ) {
            $id = 'receipt_';
        }
        $this->id = new Id(uniqid($id, false));
    }

    public  function add_item(Line_Item $item){
        $this->line_items[] = $item;
    }

    public function id(): ID{
        return $this->id;
    }

    public function subtotal():int{
        return array_reduce($this->line_items,
            function($accum, $item){
             return $accum + $item->subtotal();
            },0);
    }

    public function total() : int {
          return array_reduce($this->line_items, function($carry, $li,){
             return $carry + $li->total();
          }, 0);
    }
    public function tax(): array{
        return array_map(function($item){
            return $item->tax();
        }, $this->line_items);
    }
    public function tax_amount():int {
        return array_reduce($this->line_items, function($carry, $item){
          return $carry + $item->taxes();
        }, 0);

    }

    public function create_sql():array {
        return array_map(function ($i) {
            return $i->sql_values();
        }, $this->line_items );
    }

    public static function retrieve_by_vendor(string $value) : string { // todo implement vendor, category, & date implementations...

       $sql = "SELECT * FROM line_items WHERE vendor LIKE '{$value}' ";
//        print_r($sql) . PHP_EOL; //works
        return $sql;
    }
    public function retrieve_by_category(string $value) : string { // todo implement vendor, category, & date implementations...

        return "SELECT * FROM line_items WHERE category = $value ";

    }

    public function retrieve_by_date(string $value) : string { // todo implement vendor, category, & date implementations...
//
//        return "SELECT * FROM line_items WHERE (date = "$value`) ";
//                                    //date format yyyy-mmm-dd

    }

    public function populate_categories(?array $cat_list = array()){
        if( !empty($cat_list) ) {
            $this->category_list = [$cat_list];

        } else {
            array_push($this->category_list,
                "",
                "Produce",
                "Meat",
                "Seafood",
                "Deli",
                "Bakery",
                "Seafood",
                "Household",
                "Alcohol",
                "Weed",
                "Snacks",
                "Utilities",
                "Maintenance",
                "Auto",
                "Clothing",
                "Toys",
                "Entertainment",
                "Medical"
            );
        }
    }


    public function removeItem($id){

    }

}
