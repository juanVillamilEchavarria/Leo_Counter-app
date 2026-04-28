<?php

namespace App\Application\Cuenta\Commands\Handlers;

use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Application\Cuenta\Commands\StoreCuentaCommand;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;

/**
 * Handler encargado de crear una nueva Cuenta
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Cuenta\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StoreCuentaHandler
{
    public function __construct(
        private CuentaRepositoryContract $repository
    ) {}

    public function __invoke(StoreCuentaCommand $command)
    {
        $cuenta = Cuenta::create(
            nombre: $command->nombre,
            notas: $command->notas,
            saldo_inicial: $command->saldo_inicial,
            propietario_id: $command->propietario_id,
            tipo_cuenta_id: $command->tipo_cuenta_id,
        );

        return $this->repository->store($cuenta);
    }
}