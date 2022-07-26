<?php

namespace app;

class PST implements Tax_Interface
{
    private int $rate;
    private Id $id;

    public function __construct(int $tax_rate = 0 )    {
        $this->rate = $tax_rate;
        $this->id = new Id('tax_');
    }

    public function rate(): int    {
        return $this->rate;
    }

    public function id(): Id    {
        return $this->id;
    }

    public function identity(): PST  {
        return $this;
    }
}