<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    // protected function attemptLogin(Request $request)
    // {
    //     $credentials = $this->credentials($request);  // Get the credentials (email and password)

    //     // Check if the user exists and if their customer_type is 1
    //     $user = User::where('email', $credentials['email'])->first();

    //     if ($user && $user->customer_type === 1) {
    //         return $this->guard()->attempt($credentials, $request->filled('remember'));
    //     }

    //     // If the user doesn't exist or the customer_type is not 1, deny login
    //     return false;
    // }

    // /**
    //  * Override the sendFailedLoginResponse method to show a custom error message.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\RedirectResponse
    //  */
    // protected function sendFailedLoginResponse(Request $request)
    // {
    //     return redirect()->back()->withErrors(['email' => 'You are not allowed to login.']);
    // }
}
