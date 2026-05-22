<?php

namespace App\Application\Notificacion\Commands\Handlers;

use App\Application\Notificacion\Commands\DestroySuscriptorNotificacionCommand;
use App\Domains\Notificacion\Contracts\Repositories\SuscriptorNotificacionRepositoryContract;
use App\Domains\Notificacion\ValueObjects\SuscriptorNotificacionId;

final readonly class DestroySuscriptorNotificacionHandler
{
    public function __construct(
        private SuscriptorNotificacionRepositoryContract $repository
    ){}

    public function __invoke(DestroySuscriptorNotificacionCommand $command): bool
    {
        return $this->repository->destroy(new SuscriptorNotificacionId($command->id));
    }
}
