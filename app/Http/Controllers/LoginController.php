<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends MainController
{

    public function __construct() {
       if(Auth::user()){
            return redirect()->intended('dashboard');
       }else{
             $this->middleware('guest')->except('userLogout');
       }
       
    }

    public function index() {
    	return view('auth.login');
    }

    public function authenticate(Request $request) {

    	$request->validate([
    		'username' => 'required',
    		'password' => 'required'
    	]);

    	$credentials = $request->only('username', 'password');
    	if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
    	
    	return redirect("login")->withSuccess('Invalid Username or Password');
    }

    public function userLogout(Request $request) {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
