<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login' => Carbon::now(),
        ]);

        // 1

        // Redirect based on user role
        if ($user->role === 'lecturer') {
            return redirect()->intended('/lecturer-home');
        } elseif ($user->role === 'student') {
            return redirect()->intended('/student-register');
        } elseif ($user->role === 'administrator') {
            return redirect()->intended('/admin-dashboard');
        }

        // Default redirect
        return redirect()->intended($this->redirectPath());

    }

}
