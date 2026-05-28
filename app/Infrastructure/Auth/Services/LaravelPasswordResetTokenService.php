<?php

namespace App\Infrastructure\Auth\Services;

use App\Domains\Auth\Contracts\Services\PasswordResetTokenServiceContract;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

/**
 * Servicio Laravel para generar, validar y eliminar tokens de restablecimiento de contraseña.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Auth\Services
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelPasswordResetTokenService implements PasswordResetTokenServiceContract
{
    /**
     * @inheritDoc
     */
    public function createToken(string $email): string
    {
        return Password::createToken(
            User::where('email', $email)->firstOrFail()
        );
    }

    /**
     * @inheritDoc
     */
    public function validateToken(string $email, string $token): bool
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        return Password::tokenExists($user, $token);
    }

    /**
     * @inheritDoc
     */
    public function deleteToken(string $email): void
    {
        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();
    }
}
