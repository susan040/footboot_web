<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = new user();
        $superadmin->name = "Superadmin";
        $superadmin->email = "admin@admin.com";
        $superadmin->phone = "9814277600";
        $superadmin->status = "Active";
        $superadmin->role = "superadmin";
        $superadmin->password = bcrypt("12345678");
        $superadmin->save();

        $vendor = new user();
        $vendor->name = "Vendor";
        $vendor->email = "vendor@vendor.com";
        $vendor->phone = "9814277610";
        $vendor->status = "Active";
        $vendor->role = "vendor";
        $vendor->password = bcrypt("12345678");
        $vendor->save();
    }
}
