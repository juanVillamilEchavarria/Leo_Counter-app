<?php

namespace App\Application\Cuenta\Commands\Handlers;

use App\Application\Cuenta\Commands\DestroyCuentaCommand;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;

/**
 * Handler for destroying a Cuenta
 */
final readonly class DestroyCuentaHandler
{
    public function __construct(
        private CuentaRepositoryContract $repository,
    ) {}

    public function __invoke(DestroyCuentaCommand $command)
    {
        return $this->repository->destroy($command->id);
    }
}