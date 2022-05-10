<?php

namespace app;

class Tax
{
    public int $rate;
    private string $name;
    public array $error = [];

    public function __construct( string $name, int $tax_rate )    {
        $this->rate = $tax_rate;
        $this->name = $name;
    }

    public function rates(): int    {
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