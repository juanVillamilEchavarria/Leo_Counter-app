<?php

namespace App\Application\Cuenta\Commands\Handlers;

use App\Application\Cuenta\Commands\ToggleCuentaCommand;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Cuenta\Exceptions\CannotFindCuentaException;

/**
 * Handler para alternar el valor de un atributo booleano en una Cuenta
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Cuenta\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ToggleCuentaHandler
{
    public function __construct(
        private CuentaRepositoryContract $repository,
    ) {}

    public function __invoke(ToggleCuentaCommand $command): bool
    {
        $result = $this->repository->toggle($command->id, $command->attribute);
        return $result ?: throw new CannotFindCuentaException(""); 
    }
}