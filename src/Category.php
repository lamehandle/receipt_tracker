<?php

namespace app;

class Category
{
    private string $category;

    public function __construct(string $item_cat)
    {
        $this->category = $item_cat;
    }

    public function category(): string {
        return $this->category;
    }

    public function is_equal(Category $cat):bool{
         return $this->category() === $cat->category();
    }

}

