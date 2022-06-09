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

    public function tax():int {
        return array_reduce($this->line_items, function($carry, $item){
          return $carry + $item->taxes();
        }, 0);

    }

    public function create_sql():array {
        return array_map(function ($i) {
            return $i->sql_values();
        }, $this->line_items );
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
        $this->line_items = array_filter($this->line_items, function ($item) use ($id){
                   return $item->id !== $id;
               });

        array_map(function ($item) use ($id) {
            if($item->id === $id){
                $this->remove_category_from_list($item->category);
            }
        }, $this->categories->category_list);
    }

}
