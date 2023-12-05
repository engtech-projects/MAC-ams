<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
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
            redirect()->intended('dashboard');
        } else {
            $this->middleware('guest')->except('userLogout');
        }

    }

    public function index()
    {
        $title = 'Login'.' - '.config('app.name');

        return view('auth.login')->with(compact('title'));
    }

    public function authenticate(LoginRequest $request )
    {
        $userModel = new User();
        $credentials = $request->validated();
        $branchId = $credentials["branch_id"];
        $credentials = $request->only('username', 'password');
        $user = $userModel->getUserBranch(['username' => $credentials['username'],'branch_id' => $branchId]);

        if ($user && count($user->userBranch) > 0) {
            if (Auth::attempt($credentials)) {
                $branchId = $user->userBranch[0]->branch_id;
                session()->put('auth_user_branch', $branchId);
                return response()->json(['message' => "successfully logged in."],200);

            }
        }
        return response()->json(['message' => "Invalid credentials."],401);




    }


    public function userLogout(Request $request)
    {
        Auth::logout();
        session()->forget('auth_user_branch');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("login")->withSuccess('Successfully Logged out. ');
    }

}
