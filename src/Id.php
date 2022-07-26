<?php

namespace app;

class Id implements Id_Interface
{
    private string $id;

    public function __construct(string $prefix) {
        $this->id = uniqid($prefix, false);
    }

    public function id() : string {
        return $this->id;
    }

    public function identity(): Id {
        return $this;
    }

}