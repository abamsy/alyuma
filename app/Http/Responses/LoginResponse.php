<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        
        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade

        if (Auth::user()->isReceiver()){
            return redirect()->route('ballocations', [Auth::user()->plant->id]);
        }
        elseif(Auth::user()->isDispatcher()){
            return redirect()->route('lallocations', [Auth::user()->point->id]);
        }
        else{
            return redirect()->route('users');
        }
        
        //return $request->wantsJson()
                    //? response()->json(['two_factor' => false])
                    //: redirect()->intended(config('fortify.home'));
    }

}