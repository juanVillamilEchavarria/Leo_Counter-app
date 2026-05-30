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

use App\Domains\Usuario\ValueObjects\UsuarioId;

/**
 * Interfaz que define el contrato para verificar si un usuario puede actualizar su datos publicos relacionados con un canal de notificación.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface UsuarioCanUpdatePublicDataCheckerContract
{

    /**
     * verifica si el usuario puede actualizar los campos publicos relacionados con un canal de notificación.
     * si el usuario no esta suscrito a ningun canal, puede actualizar sus datos publicos
     *
     * @param UsuarioId $id
     * @return bool
     */
    public function userCanUpdateHisPublicDataRelatedToANotificationChannel(UsuarioId $id): bool;
}
