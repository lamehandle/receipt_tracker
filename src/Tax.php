<?php

namespace app;

class Tax
{
    public int $rate;
    private string $name;
    public array $error = [];

    public function __construct( string $name, array ...$tax_rate )    {
        //todo rewrite to take an array of values
        $this->rate[] = $tax_rate;
        $this->name = $name;
    }

    public function rates(): array    {
        return $this->rate;
    }

    public function name(): string    {
        return $this->name;
    }

    public function errors():array{
        if (empty($this->rate)) {
            $this->error[] = "No rates available.";
        }
        return $this->error;
    }
}