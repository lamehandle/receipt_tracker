<?php

namespace app;

class Filter
{
    public static function filter_by_vendor(Receipt $receipt, string $vendor): Receipt{

        $vend_match = array_filter($receipt->line_items, function($item) use ($vendor) {
            return $item->vendor->name() === $vendor;
        });

        $new_receipt = (new Receipt(uniqid('vend_filt_', false)));

        foreach ($vend_match as $el){
            $new_receipt->line_items[] = $el;
        }
        return $new_receipt;
    }


    public static function filter_by_item_name(Receipt $receipt, string $item_name):Receipt{

        $name_match = array_filter($receipt->line_items, function($item) use ($item_name) {
            return $item->item->name() === $item_name;
        });

        $new_receipt = new Receipt(uniqid("item_filter_", false));

        foreach ($name_match as $el){
            $new_receipt->line_items[] = $el;
        }
        return $new_receipt;
    }

    public static function filter_by_category(Receipt $receipt, string $category): Receipt{

        $cat_match = array_filter($receipt->line_items, function(Line_Item $item) use ($category) {
            return $item->category->name() === $category;
        });

        $new_receipt = new Receipt(uniqid("cat_filter_", false));

        foreach ($cat_match as $el){
            $new_receipt->line_items[] = $el;
        }
        return $new_receipt;
    }
}

