<?php

namespace app;

interface Purchase_Record
{
    public function subtotal():float;
    public function total():mixed;
    public function taxes():array;
}