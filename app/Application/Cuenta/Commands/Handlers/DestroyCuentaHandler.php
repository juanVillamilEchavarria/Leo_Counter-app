<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Cuenta\Commands\Handlers;

use App\Application\Cuenta\Commands\DestroyCuentaCommand;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Cuenta\ValueObjects\CuentaId;

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
        return $this->repository->destroy(new CuentaId($command->id));
    }
}