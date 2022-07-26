<?php

namespace app;

interface Currency_Interface {

    public function amount(): int;
    public function as_string(): string;
    public function Id(): self;

}