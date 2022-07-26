<?php

namespace app;

class Item implements Text_Field_Interface  {

    private string $name;
    private Id $id;

    public function __construct(string $name)    {
        $this->name = $name;
        $this->id = new Id('Item_');
    }

    public function name(): string    {
        return $this->name;
    }

    public function id(): Id    {
        Return $this->id;
    }

    public function identity(): Item   {
        return $this;
    }
}