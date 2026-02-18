<?php

namespace App\Domains\Auth\Services\Application;

use App\Domains\Auth\Services\Domain\LoginService;
use Illuminate\Support\Facades\Hash;

final class AuthService {
    public function __construct(
        private LoginService $loginService
    )
    {
    }

    public function login ( array $credentials, bool $remember = false ): bool {
        return $this->loginService->login($credentials, $remember);
    }

    public function logout (): void {
        $this->loginService->logout();
    }

    public function getAuthenticatedUser() {
        return auth()->user();
    }

    public function verifyPassword(string $password): bool {
        $user = $this->getAuthenticatedUser();
        if(!$user){
            return false;
        }
        return Hash::check($password, $user->password);
    }
}