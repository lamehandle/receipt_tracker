<?php

namespace app;


class Receipt implements Purchase_Record
{
    public array $line_items = [];
    public array $category_list = [];
    private string $id;

    public function __construct($id){
        $this->id = $id;

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

    public function addItem(Line_Item $item){
        $this->line_items[] = $item;
        $this->append_category($item->category);
    }

    public function removeItem($id){
        $this->line_items = array_filter($this->line_items, function ($item) use ($id){
                   return $item->id !== $id;
               });
//        array_map(function ($item) use ($id) {
//            if($item->id === $id){
//                $this->remove_category_from_list($item->category);
//            }
//        }, $this->categories->category_list);
    }

    public function append_category($new_category)
    {
        //todo revisit implementation
        if( gettype($new_category ) !== "array"){
            $this->category_list[] = $new_category;

        }else {
            array_walk_recursive($new_category, function($item){
                return $this->category_list[] =  $item;
            });
        }
    }

    public function remove_category_from_list(string $category_to_remove): void
    {
        $this->category_list = array_filter($this->category_list, function ($cat) use ($category_to_remove){
            return $cat !== $category_to_remove;
        });
    }


    public function get_category_list(?array $filtered_list ): array
    {
        if (empty($filtered_list)) {
            return $this->category_list;
        }else{
            return $this->filtered_list = $filtered_list;
        }
    }


    public function subtotal():Currency_Field{
        return (new Currency_Field(array_reduce($this->line_items,
            function($accum, $item){
             return $accum + $item->subtotal();
            },0)));
    }

    public function taxes():array {
        // creates array of calculated tax values
        $tax_values = array_map( function ($item){
            return $item->taxes();
        }, $this->line_items);

        //creates an array of all unique tax keys
        $tax_keys = array_unique(
            array_merge(
            ...array_map(
                'array_keys', $tax_values)));

         return array_map(function($tax_key) use ( $tax_values) {
                return array_sum( //sum the below calculated rates for each tax type
                    array_map(function($tax_values ) use ($tax_key){
                    return $tax_values[$tax_key] ?? 0; // return the tax amount for each key or 0.
                    }, $tax_values)
                );
            }, $tax_keys); //returns the sum of all the taxes
    }

    public function total() : float {
          return $this->subtotal() + array_sum($this->taxes());
    }

}
