<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(): View
    {
        return view("auth.login");
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentialsData = $request->validate([
            'email' => 'required|string|email|max:40|',
            'password' => 'required|string|min:8',
        ]);

        //Authenticate user
        if (Auth::attempt($credentialsData)) {
            //If login success, then....

            //Prevent fixation attacks by regenerating session
            //https://owasp.org/www-community/attacks/Session_fixation
            $request->session()->regenerate();

            return redirect()->intended(route('home'))->with('status', 'You are logged in!');
        }
        //If login fails

        return back()->with('error', 'Incorrect credentials');
    }

    public function logout(Request $request): RedirectResponse
    {
        //$request->session()->remove
        Auth::logout();

        //https://www.slingacademy.com/article/laravel-how-to-log-out-a-user/

        // Invalidate the current session and regenerate the token
        $request->session()->invalidate();

        // Generate a new session token
        $request->session()->regenerateToken();


        return redirect()->intended(route('home'))->with('status', 'You have successfully logged out!');
    }
}
