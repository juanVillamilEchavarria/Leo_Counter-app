<?php

namespace App\Domains\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginService {
    public function login ( array $credentials, bool $remember = false ): bool {
        if(!Auth::attempt($credentials, $remember)){
            return false;
        }
        request()->session()->regenerate();
        return true;
    }

    public function logout (): void {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}