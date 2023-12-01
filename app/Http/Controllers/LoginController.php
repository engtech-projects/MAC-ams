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
        return view('auth.login');
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

        $user = $userModel->getUserByUsername(['username' => $credentials['username'],'branch_id' => $branchId]);
        if ($user && count($user->userBranch) > 0) {
            if (Auth::attempt($credentials)) {
                return response()->json(['message' => 'Successfully logged in.'],200);
                /* return redirect()->intended('dashboard')
                    ->withSuccess('Signed in'); */
            }
        }
        return response()->json(['message' => 'Credentials not found.'],401);
        /* return redirect("login")->withSuccess('Credentials not found.'); */
        //return redirect("login")->withSuccess('Invalid Username or Password');



        /* $fields = $request->validate([
            'username'         => 'required|string',
            'password'      => 'required|string'
        ]);

        $user = User::where('username', $fields['username'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message'   => 'Credentials not Found'
            ], 401);
        }

        $token = $user->createToken('mac-ams-token')->plainTextToken;

        $response = [
            'user'          => $user,
            'token'         => $token
        ]; */

        //return response($response, 201);
    }

    /* public function user(Request $request) {
        return $request->user();
    } */

    public function userLogout(Request $request)
    {

        /* $user = Auth::user()->userBranch;
        return response()->json(['data' => $user]); */
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("login")->withSuccess('Successfully Logged out. ');
    }

}
