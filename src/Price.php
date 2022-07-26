<?php

namespace app;

class Price implements Currency_Interface
{
    private int $amount;
    private Id $id;

    public function __construct($amount)    {
        $this->amount = $amount;
        $this->id = new Id('$price_');
    }

    public function amount(): int     {
        return $this->amount;
    }

    public function as_string(): string  {
        return number_format($this->amount, 2, ".",",");
    }

    public function Id(): Price   {
        return $this;
    }
}