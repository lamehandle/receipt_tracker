<?php

namespace app;

interface Text_Field_Interface  {
    public function name(): string;
    public function id() : Id;
    public function identity() : self;
}