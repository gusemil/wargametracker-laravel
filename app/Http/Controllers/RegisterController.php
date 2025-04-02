<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function register(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        //Check if email is already in use
        $emailToCheck = DB::table('users')->where('email', $request->email)->value('email');

        if ($request->email == $emailToCheck) {
            return back()->with('error', "An user with this email already exists $emailToCheck");
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:40',
            'email' => 'required|string|email|max:40|unique:users',
            //'email' => 'required|string|email|max:100|confirmed',
            //'password' => 'required|string|min:8|confirmed',
            'password' => 'required|string|min:8',
            'password_verify' => 'required|string|min:8'
        ]);

        if ($validatedData['password'] != $validatedData['password_verify']) {
            return back()->with('error', 'Password and password verify are not equal');
        }

        //Hash the password
        $validatedData['password'] = Hash::make($validatedData['password']);

        //Create user and save to the DB
        $user = User::create($validatedData);

        //Redirect to login page with a flash message
        return redirect()->route('login')->with('status', 'Registration completed');
    }
}
