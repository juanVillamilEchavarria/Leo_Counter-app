<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Queries\Executors\Checkers;

use App\Domains\Notificacion\Aggregates\Canal;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Shared\Domain\Contracts\Checkers\UsuarioCanBeNotifiedByAChannelCheckerContract;
use App\Models\Notificacion\SuscriptorNotificacion;

final readonly class EloquentUsuarioCanBeNotifiedByChannelChecker implements UsuarioCanBeNotifiedByAChannelCheckerContract
{

    /**
     * @inheritDoc
     */
    public function checkIfUsuarioCanBeNotifiedByAChannel(Usuario $usuario, Canal $canal): bool
    {
        return SuscriptorNotificacion::where([
            'user_id' => $usuario->getId()->getValue(),
<<<<<<< HEAD
            'canal_notificacion_id' => $canal->getId()->getValue(),
            'active' => true
=======
            'canal_notificacion_id' => $canal->getId()->getValue()
>>>>>>> 23def1b7b9d919ef710829c8b7a5a63623b7ed7b
        ])->exists();
    }
}
