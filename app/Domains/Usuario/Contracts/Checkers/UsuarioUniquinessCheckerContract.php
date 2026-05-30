<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Usuario\Contracts\Checkers;

/**
 * Contrato para la verificacion de unicidad de usuarios.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface UsuarioUniquinessCheckerContract
{

    /**
     * Verifica si el usuario administrador ya ha sido creado.
     * @return bool
     */
    public function checkIfAdminWasAlreadyCreated(): bool;

}
