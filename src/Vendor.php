<?php

namespace app;

class Vendor implements Text_Field_Interface
{
    private string $name;
    private Id $id;

    public function __construct(string $name)    {
        $this->name = $name;
        $this->id = new Id('vend_');
    }

    public function name(): string     {
        return $this->name;
    }

    public function id() : Id    {
        return $this->id;
    }

    public function identity(): Vendor  {
        return $this;
    }
}