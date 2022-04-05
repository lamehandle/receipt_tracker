<?php

namespace app;

interface Purchase_Record
{
    public function subtotal():Currency_Field;
    public function total():mixed;
    public function taxes():array;
}