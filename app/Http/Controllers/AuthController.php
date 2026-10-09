<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        //pokus o prihlasenie
         if(Auth::attempt($credentials))
         {
            $request->session()->regenerate();

            return redirect()->intended(route('tasks.index'))->with('success', 'Bol si uspesne prihlaseny');

         } 
         
         //ak prihlasenie je neuspesne
         return back()->withErrors([
            'email' => 'Zadane prihlasovacie udaje nie su spravne !!!!',
         ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Boli ste uspesne odhlaseny!!!');
    }
}

