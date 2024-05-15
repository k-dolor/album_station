<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gender;
use Illuminate\Validation\Validator;


class UserController extends Controller
{

    public function login(){
        return view ('login.login');
    }

    public function processLogin(Request $request){
        $validated = $request->validate([
            'username' => ['required', 'max:12'],
            'password' => ['required', 'max:15']
        ]);

        $user = User::where('username',  $validated['username'])->first();

        if($user && auth()->attempt($validated)) {
            auth()->login($user);
            $request->session()->regenerate();

            return redirect ('/home');
        } else {
        return back()-> with('message_success', 'Username or Password Invalid.');
        }
    }

    public function logout(){
        return view ('logout.logout');
    }
    public function processLogout(Request $request){
        auth()->logout();

        $request-> session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}