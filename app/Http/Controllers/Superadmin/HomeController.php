<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $data['vendors'] = User::where('role', 'vendor')->count();
        $data['categories'] = Category::count();
        return view("superadmin.home", $data);
    }
}
