<?php

namespace app;

interface Tax_Interface {

    public function rate(): int;
    public function id(): Id;
    public function identity(): GST|PST;

}