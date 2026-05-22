<?php

namespace App\Application\Notificacion\Commands\Handlers;

use App\Application\Notificacion\Commands\UpdateCanalNotificacionConfigCommand;
use App\Domains\Notificacion\Contracts\Repositories\CanalNotificacionRepositoryContract;
use App\Domains\Notificacion\ValueObjects\CanalNotificacionId;
use App\Domains\Notificacion\Exceptions\CanalNotificacionNotFoundException;
use App\Domains\Notificacion\Exceptions\CannotUpdateCanalNotificacionException;

final readonly class UpdateCanalNotificacionConfigHandler
{
    public function __construct(
        private CanalNotificacionRepositoryContract $repository
    ){}

    public function __invoke(UpdateCanalNotificacionConfigCommand $command): bool
    {
        $canal = $this->repository->findById(new CanalNotificacionId($command->id));
        if (!$canal) {
            throw new CanalNotificacionNotFoundException();
        }

        $updated = $canal->actualizarConfiguracion($command->configuracion);

        $result = $this->repository->update($updated);
        if (!$result) {
            throw new CannotUpdateCanalNotificacionException(message: 'No se pudo actualizar la configuración del canal');
        }
        return $result;
    }
}
