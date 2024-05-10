<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Auth;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MenuFilter implements FilterInterface
{
    public function transform($item)
    {
        if (isset($item['role']))
            if (TypeHelper::check() != ($item['role'] ?: "") && ($item['role'] ?: "All") != "All") {
//        if (!Auth::user()->hasRole($item['role'] ?? "") && ($item['role'] ??"All")!= "All" ) {
                $item['restricted'] = true;
            }
        return $item;
    }
}
