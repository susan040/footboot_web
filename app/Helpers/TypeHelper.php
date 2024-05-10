<?php


namespace App\Helpers;


class TypeHelper
{
    static function check(){

            return auth()->user()->role;
    }
}
