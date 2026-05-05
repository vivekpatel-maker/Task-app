<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
public function showRegister()
{
    if (auth()->check()) {
        return redirect('/tasks');
    }
    return view('auth.register');
}

public function register(Request $req){
        $req->validate([
            'name' => [
                'required',
                'max:30',
                'regex:/^[A-Za-z\s]+$/'
            ],

            'email' => [
                'required',
                'email',
                'max:50',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'min:6',
                'max:12'
            ]
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password)
        ]);
        Auth::login($user);

        return redirect('/tasks')->with('success', 'Registered successfully');
    }

    public function showLogin(){
        if (auth()->check()) {
            return redirect('/tasks');
        }
        return view('auth.login');
    }


    public function login(Request $req){
        $req->validate([
            'email' => [
                'required',
                'email',
                'max:50'
            ],
            'password' => [
                'required',
                'min:6',
                'max:12'
            ]
        ]);

        if (Auth::attempt($req->only('email', 'password'))) {
            return redirect('/tasks');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
