<?php

namespace App\Application\Notificacion\Commands\Handlers;

use App\Application\Notificacion\Commands\ToggleCanalCommand;
use App\Domains\Notificacion\Contracts\Repositories\CanalRepositoryContract;
use App\Domains\Notificacion\Exceptions\CanalNotificacionNotFoundException;

final readonly class ToggleCanalHandler
{
    public function __construct(
        private CanalRepositoryContract $repository
    ){}

    public function __invoke(ToggleCanalCommand $command): bool
    {
        $result = $this->repository->toggle(new \App\Domains\Notificacion\ValueObjects\CanalId($command->id), $command->attribute);
        return $result !== true ? throw new CanalNotificacionNotFoundException() : $result;
    }
}
