<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class LoginUserController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function store(Request $request){
        //validate the form data

        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8, string'

        ]);

        //attempt to log user in

        if(Auth::guard('web')->attempt(['email'=>$request->email, 'password'=>$request->password])){
            //if successfull then redirect to thier intended location
            return redirect()->intended(route('posts.index'));
        } else{
            return back()->withError([
                'email'=> 'The provided crendials do not match our records'
            ]);
        }
    }

    public function logout(Request $request){

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('posts.index');

    }
}
