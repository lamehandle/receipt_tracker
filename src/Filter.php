<?php

namespace app;

class Filter
{
    public static function filter_by_vendor(Receipt $receipt, string $vendor):Receipt{

        $vend_match = array_filter($receipt->line_items, function($item) use ($vendor) {
            return $item->vendor === $vendor;
        });

        $new_receipt = new Receipt(uniqid("filtered_", false));
        $new_receipt->line_items = $vend_match;

        return $new_receipt;

    }

    public static function filter_by_item_name(Receipt $receipt, string $item_name):Receipt{

        $item_match = array_filter($receipt->line_items, function($item) use ($item_name) {
            return $item->item === $item_name;
        });

        $new_receipt = new Receipt(uniqid("filtered_", false));
        $new_receipt->line_items = $item_match;

        return $new_receipt;
    }

    public static function filter_by_category(Receipt $receipt, string $category):Receipt{

        $category_match = array_filter($receipt->line_items, function($item) use ($category) {
            return $item->category->is_equal((new Category($category)));
        });

        $new_receipt = new Receipt(uniqid("filtered_", false));
        $new_receipt->line_items = $category_match;

        return $new_receipt;
    }

    public static function clear_filter(Receipt $receipt):void{
        $receipt->line_items = [];
    }
}

