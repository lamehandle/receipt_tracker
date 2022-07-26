<?php

namespace app;

class Data_Rep
{
    private string  $name;
    private array   $data;


    public function __construct(array $data) {
        $this->name = $data['item'];
        $this->data = $data;
    }

    public function name() : string {
        return $this->data['item'];
    }

    public function data(): array  {
        return $this->data;

    }

    public function identity(): Data_Rep    {
        return $this;
    }

    public function valid():    bool {
        return !empty( $this->data );
    }
}


