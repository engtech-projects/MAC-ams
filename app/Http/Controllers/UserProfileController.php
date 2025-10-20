<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\User;
use Hash;

class UserProfileController extends MainController
{
    public function index()
    {
        return view('user.profile')->with([
            'title' => 'User Profile' . ' - ' . config('app.name'),
            'nav' => ['user', 'profile'],
            'user' => Auth::user(),
        ]);
    }

    public function updateUsername(Request $request)
    {
        // dd($request->all());
        $user = User::find(Auth::user()->id);
        $replicate = $user->replicate();
        $user->username = $request->username;
        $user->save();
        $changes = getChanges($user, $replicate);
        activity("System Setup")->event("updated")->performedOn($user)
            ->withProperties(['attributes' => $changes['attributes'], 'old' => $changes['old']])
            ->log("User - Update");
        Session::flash('success', 'Username updated successfully.');
        return redirect(route('user.profile'));
    }

    public function updatePassword(Request $request)
    {
        if ($request->new !== $request->confirm) {
            Session::flash('confirm_error', 'Confirmed password did not match.');
            return redirect()->route('user.profile');
        } else if (!Hash::check($request->current, Auth::user()->password)) {
            Session::flash('password_error', 'Current password is incorrect.');
            return redirect()->route('user.profile');
        } else {
            $user = User::find(Auth::user()->id);
            $replicate = $user->replicate();
            $user->password = bcrypt($request->new);
            $user->save();
            $changes = getChanges($user, $replicate);
            activity("System Setup")->event("updated")->performedOn($user)
                ->withProperties(['attributes' => $changes['attributes'], 'old' => $changes['old']])
                ->log("User - Update");
            Session::flash('success', 'Password has been successfully updated.');
            return redirect()->route('user.profile');
        }
    }
}
