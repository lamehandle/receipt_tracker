<?php

namespace app;

interface Purchase_Record
{
    public function subtotal():float;
    public function total():float;
    public function taxes():Taxes;
}