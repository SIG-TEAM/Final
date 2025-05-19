<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif (auth()->user()->role === 'pengurus') {
            return redirect()->intended('/pengurus/dashboard');
        }
        
        return redirect()->intended('/dashboard');
    }
} 