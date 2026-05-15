<?php

namespace App\Shared\Infrastructure\Framework\Laravel\Services\Auth;

use App\Models\User;
use App\Shared\Application\Contracts\Services\AuthServiceContract;
use Illuminate\Support\Facades\Hash;

class LaravelAuthService implements AuthServiceContract
{
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
