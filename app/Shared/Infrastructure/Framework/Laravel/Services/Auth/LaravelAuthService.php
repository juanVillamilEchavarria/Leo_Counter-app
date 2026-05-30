<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Framework\Laravel\Services\Auth;

use App\Models\User;
use App\Shared\Application\Contracts\Services\AuthServiceContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LaravelAuthService implements AuthServiceContract
{
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
    private function getAuthenticatedUser(): User{
        return auth()->user();
    }

    /**
     * @inheritDoc
     */
    public function verifyPasswordForLoggedInUser(string $password): bool
    {
        $user = $this->getAuthenticatedUser();
        if(!$user){
            return false;
        }
        return Hash::check($password, $user->password);
    }
}
