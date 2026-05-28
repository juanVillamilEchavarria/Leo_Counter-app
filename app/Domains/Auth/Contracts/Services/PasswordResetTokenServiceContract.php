<?php

namespace App\Domains\Auth\Contracts\Services;

/**
 * Contrato del servicio de dominio para administrar tokens de restablecimiento de contraseña.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Auth\Contracts\Services
 * @since 1.0.0
 * @version 1.0.0
 */
interface PasswordResetTokenServiceContract
{
    /**
     * Genera y almacena un token de restablecimiento para el email indicado.
     *
     * @param string $email Correo electronico del usuario.
     * @return string Token plano que se enviara al usuario.
     */
    public function createToken(string $email): string;

    /**
     * Valida si existe un token vigente para el email indicado.
     *
     * @param string $email Correo electronico del usuario.
     * @param string $token Token plano recibido desde el enlace.
     * @return bool Resultado de la validacion.
     */
    public function validateToken(string $email, string $token): bool;

    /**
     * Elimina los tokens asociados al email tras un restablecimiento exitoso.
     *
     * @param string $email Correo electronico del usuario.
     * @return void
     */
    public function deleteToken(string $email): void;
}
