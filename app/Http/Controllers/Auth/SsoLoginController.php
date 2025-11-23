<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SsoLoginController extends Controller
{
    public function login(Request $request, User $user)
    {
        \Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('home');
    }
}
