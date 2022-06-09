<?php

namespace app;

class Data_Rep
{
    private string  $name;
    private array   $data;


    public function __construct(string $name, array $data) {
        $this->name = $name;
        $this->data = $data;
    }

    public function name() : string {
        return $this->name;
    }

    public function data(): array  {
        return $this->data;

    }

    public function sql_values()
    {

    }

    public function valid():bool {
        return !empty( $this->name ) && !empty( $this->data );
    }
}


