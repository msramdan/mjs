<?php

namespace App\Helpers;


class Myhelper
{
    public static function indo_currency($nominal)
    {
        // $result = "Rp " . number_format($nominal, 2, ',', '.');
        // return $result;
        $result =number_format($nominal, 0, ',', ',');
        return $result;
    }

}
