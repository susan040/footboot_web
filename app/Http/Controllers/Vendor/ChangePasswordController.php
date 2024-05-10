<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    function changePassword()
    {
        $info['title'] = 'Change Password';
        $info['hideCreate'] = true;
        return view('vendors.change_password', $info);
    }

    function changePasswordSave(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);
        $vendor = User::findOrFail(auth()->user()->id);
        if (Hash::check($request->old_password, $vendor->password)) {
            $vendor->password = Hash::make($request->new_password);
            $vendor->save();
            return redirect()->back()->with('success', 'Password Changed Successfully.');
        } else {
            return redirect()->back()->withInput($request->input())->with('error', 'Old Password Mismatched.');
        }
    }
}
