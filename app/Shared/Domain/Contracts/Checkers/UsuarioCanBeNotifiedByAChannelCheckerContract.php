<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Domain\Contracts\Checkers;
use App\Domains\Notificacion\Aggregates\Canal;
use App\Domains\Usuario\Aggregates\Usuario;

/**
 * Contrato que deben implementar los checkers que verifican si el usuario puede ser notificado por un canal
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Domain\Contracts\Checkers
 * @since 1.0.0
 * @version 1.0.0
 */
interface UsuarioCanBeNotifiedByAChannelCheckerContract
{
    /**
     * Verifica si el usuario puede ser notificado por un canal
     * @param Usuario $usuario
     * @param Canal $canal
     * @return bool
     */
    public function checkIfUsuarioCanBeNotifiedByAChannel(Usuario $usuario, Canal $canal): bool;

}
