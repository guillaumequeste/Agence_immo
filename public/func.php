<?php

function formatPrice($number): string
{
    return number_format($number, 0, ',', ' ');
}