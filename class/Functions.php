<?php

namespace App;

 class Functions {

    public $number;

    public function __construct(number $number)
    {
        $this->number = $number;
    }

    public function priceFormat(): number
    {
        return number_format($this->number, 0, ',', ' ');
    }
}