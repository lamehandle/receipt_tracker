<?php

namespace app;

class Filter
{
    public static function filter_by_vendor(Receipt $receipt, $vendor):void{
        Filter::clear_filter($receipt);
        $vend_match = array_filter($receipt->line_items, function($item) use ($vendor) {
            return $item->__get("vendor") === $vendor;
        });
        $receipt->filtered_list[] = $vend_match;
    }

    public static function filter_by_item_name(Receipt $receipt, $item_name):void{
        Filter::clear_filter($receipt);
        $item_match = array_filter($receipt->line_items, function($item) use ($item_name) {
            return $item->__get("item") === $item_name;
        });
        $receipt->filtered_list[] = $item_match;
    }

    public static function filter_by_category(Receipt $receipt, $category):void{

        $category_match = array_filter($receipt->line_items, function($item) use ($category) {
            return $item->category->__get($category) === $category;
        });
        $receipt->filtered_list[] = $category_match;
    }

    public static function clear_filter(Receipt $receipt):void{
        $receipt->filtered_list = [];
    }
}

