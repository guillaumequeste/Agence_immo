<?php

namespace App;

 class Functions {

    private $price;

    public function formatPrice()
    {
        return number_format($this->price, 0, ',', ' ');
    }
}