<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Usuario\Queries\Executors\Eloquent\Checkers;

use App\Domains\Usuario\Contracts\Checkers\UsuarioCanUpdatePublicDataCheckerContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Models\Notificacion\SuscriptorNotificacion;

/**
 * Implementacion del verificador de la actualizacion de los datos publicos del usuario usando eloquent ORM
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Usuario\Queries\Executors\Eloquent\Checkers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentUsuarioCanUpdatePublicDataChecker implements UsuarioCanUpdatePublicDataCheckerContract
{

    /**
     * @inheritDoc
     */
    public function userCanUpdateHisPublicDataRelatedToANotificationChannel(UsuarioId $id): bool
    {
        return !SuscriptorNotificacion::where('user_id', $id->getValue())->exists();
    }
}
