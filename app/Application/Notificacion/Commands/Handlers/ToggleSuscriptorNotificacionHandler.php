<?php

namespace App\Application\Notificacion\Commands\Handlers;

use App\Application\Notificacion\Commands\ToggleSuscriptorNotificacionCommand;
use App\Domains\Notificacion\Contracts\Repositories\SuscriptorNotificacionRepositoryContract;
use App\Domains\Notificacion\ValueObjects\SuscriptorNotificacionId;
use App\Domains\Notificacion\Exceptions\SuscriptorNotificacionNotFoundException;

final readonly class ToggleSuscriptorNotificacionHandler
{
    public function __construct(
        private SuscriptorNotificacionRepositoryContract $repository
    ){}

    public function __invoke(ToggleSuscriptorNotificacionCommand $command): bool
    {
        $result = $this->repository->toggle(new SuscriptorNotificacionId($command->id), $command->attribute);
        return $result !== true ? throw new SuscriptorNotificacionNotFoundException() : $result;
    }
}
