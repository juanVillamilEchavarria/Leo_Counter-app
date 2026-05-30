<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Application\Contracts\Services;

/**
 * Contrato para servicios de autenticación.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface AuthServiceContract
{
    /**
     * Inicia sesión del usuario.
     * @param array $credentials
     * @param bool $remember
     * @return bool
     */
    public function login ( array $credentials, bool $remember = false ): bool;

    /**
     * Cierra sesión del usuario.
     * @return void
     */
    public function logout (): void;
    /**
     * Verifica si la contraseña es correcta comparandola con la del usuario logueado.
     * @param string $password
     * @return bool
     */
    public function verifyPasswordForLoggedInUser(string $password): bool;

}
