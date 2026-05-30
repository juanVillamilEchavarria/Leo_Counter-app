<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Usuario\Services;

use App\Domains\Usuario\Contracts\Services\PasswordHasherContract;
use Illuminate\Support\Facades\Hash;

/**
 * Servicio de hashing de contraseñas basado en Laravel Hash.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Usuario\Services
 * @since 1.0.0
 * @version 1.0.0
 */
final class LaravelPasswordHasher implements PasswordHasherContract
{
    public function check(string $plain, string $hashed): bool
    {
        return Hash::check($plain, $hashed);
    }

    public function make(string $plain): string
    {
        return Hash::make($plain);
    }
}
