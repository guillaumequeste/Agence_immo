<?php

namespace App;

 class Functions {

    public function formatPrice($number)
    {
        return number_format($number, 0, ',', ' ');
    }
}