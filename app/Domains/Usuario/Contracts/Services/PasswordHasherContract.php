<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Usuario\Contracts\Services;

/**
 * Contrato para servicios de hashing y verificación de contraseñas.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Usuario\Contracts\Services
 * @since 1.0.0
 * @version 1.0.0
 */
interface PasswordHasherContract
{
    /**
     * Verifica una contraseña plana contra su hash persistido.
     *
     * @param string $plain Contraseña plana.
     * @param string $hashed Hash persistido.
     * @return bool
     */
    public function check(string $plain, string $hashed): bool;

    /**
     * Genera el hash de una contraseña plana.
     *
     * @param string $plain Contraseña plana.
     * @return string
     */
    public function make(string $plain): string;
}
