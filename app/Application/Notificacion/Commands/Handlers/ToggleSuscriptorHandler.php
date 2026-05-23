<?php

namespace App\Application\Notificacion\Commands\Handlers;

use App\Application\Notificacion\Commands\ToggleSuscriptorCommand;
use App\Domains\Notificacion\Contracts\Repositories\SuscriptorRepositoryContract;
use App\Domains\Notificacion\ValueObjects\SuscriptorId;
use App\Domains\Notificacion\Exceptions\SuscriptorNotificacionNotFoundException;

final readonly class ToggleSuscriptorHandler
{
    public function __construct(
        private SuscriptorRepositoryContract $repository
    ){}

    public function __invoke(ToggleSuscriptorCommand $command): bool
    {
        $result = $this->repository->toggle(new SuscriptorId($command->id), $command->attribute);
        return $result !== true ? throw new SuscriptorNotificacionNotFoundException() : $result;
    }
}
