<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/redirect';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function loginForm()
    {
        return view("auth.login");
    }

    public function userLogin(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|string|min:8'
            ]);

            $user = User::where('email', $request->email)->first();
            $remember_me  = (!empty($request->remember)) ? TRUE : FALSE;
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    if ($user->role === "superadmin"){
                        auth()->guard()->login($user, $remember_me);
                        return redirect()->route('superadmin.home');
                    } else {
                        auth()->guard()->login($user, $remember_me);
                        return redirect()->route('vendor.home');
                    }
                } else {
                    return back()->withInput($request->only('email', 'remember'))->with('passwordError', 'Oops! You have entered an invalid password. Please try again.');
                }
            } else {
                return back()->withInput($request->only('email', 'remember'))->with('emailError', 'Oops! You have entered an invalid email. Please try again.');
            }

        } catch (ValidationException $e) {
            return back()->withInput($request->only('email', 'remember'))->with('emailError', $e->getMessage());
        }

    }
}
