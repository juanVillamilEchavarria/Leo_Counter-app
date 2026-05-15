<?php

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
     * Verifica si la contraseña es correcta comparandola con la del usuario logueado.
     * @param string $password
     * @return bool
     */
    public function verifyPasswordForLoggedInUser(string $password): bool;

}
