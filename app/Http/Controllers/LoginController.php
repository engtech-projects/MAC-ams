<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends MainController
{

    public function __construct()
    {
        if (Auth::user()) {
            return redirect()->intended('dashboard');
        } else {
            $this->middleware('guest')->except('userLogout');
        }

    }

    public function index()
    {
        $title = 'Login'.' - '.config('app.name');

        return view('auth.login')->with(compact('title'));
    }

    public function authenticate(Request $request)
    {
        $userModel = new User();
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'branch_id' => 'required'
        ]);
        $branchId = $request->branch_id;
        $credentials = $request->only('username', 'password');
        $user = $userModel->getUserBranch(['username' => $credentials['username'],'branch_id' => $branchId]);
        if ($user && count($user->userBranch) > 0) {
            if (Auth::attempt($credentials)) {
                return response()->json(['message' => "successfully logged in."],200);
/*                 return redirect()->intended('dashboard')
                    ->withSuccess('Signed in'); */
            }
        }else {
            return response()->json(['message' => "Invalid credentials."],401);
/*             return redirect("login")->withSuccess('Credentials not found.'); */
        }



    }


    public function userLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("login")->withSuccess('Successfully Logged out. ');
    }

}
