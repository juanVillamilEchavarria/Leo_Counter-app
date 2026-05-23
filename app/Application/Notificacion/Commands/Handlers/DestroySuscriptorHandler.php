<?php

namespace App\Application\Notificacion\Commands\Handlers;

use App\Application\Notificacion\Commands\DestroySuscriptorCommand;
use App\Domains\Notificacion\Contracts\Repositories\SuscriptorRepositoryContract;
use App\Domains\Notificacion\ValueObjects\SuscriptorId;

final readonly class DestroySuscriptorHandler
{
    public function __construct(
        private SuscriptorRepositoryContract $repository
    ){}

    public function __invoke(DestroySuscriptorCommand $command): bool
    {
        return $this->repository->destroy(new SuscriptorId($command->id));
    }
}
