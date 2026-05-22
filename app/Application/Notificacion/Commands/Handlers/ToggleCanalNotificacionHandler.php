<?php

namespace App\Application\Notificacion\Commands\Handlers;

use App\Application\Notificacion\Commands\ToggleCanalNotificacionCommand;
use App\Domains\Notificacion\Contracts\Repositories\CanalNotificacionRepositoryContract;
use App\Domains\Notificacion\Exceptions\CanalNotificacionNotFoundException;

final readonly class ToggleCanalNotificacionHandler
{
    public function __construct(
        private CanalNotificacionRepositoryContract $repository
    ){}

    public function __invoke(ToggleCanalNotificacionCommand $command): bool
    {
        $result = $this->repository->toggle(new \App\Domains\Notificacion\ValueObjects\CanalNotificacionId($command->id), $command->attribute);
        return $result !== true ? throw new CanalNotificacionNotFoundException() : $result;
    }
}
