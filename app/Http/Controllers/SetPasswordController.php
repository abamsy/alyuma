<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class SetPasswordController extends Controller
{
    public function create(User $user)
    {
        if (!request()->hasValidSignature() || $user->password != '') {
            abort(401);
        }
    
        return view('auth.set-password', ['user' => $user]);
    }

    public function store()
    {
        request()->validate([
            'password' => 'required|min:8|confirmed',
            ]);
        $user = User::find(request()->id);    
        $user->update([
            'password' => bcrypt(request()->password)
        ]);

        return redirect()->route('login')->with('status', 'Password set successfully');
    }
}
