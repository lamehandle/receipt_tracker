<?php

namespace app;

interface Purchase_Record
{
    public function subtotal():int;
    public function total():int;
    public function taxes():int;
}