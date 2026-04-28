<?php

namespace App\Application\Cuenta\Commands\Handlers;

use App\Application\Cuenta\Commands\UpdateCuentaCommand;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Cuenta\Contracts\CuentaCanUpdateSaldoInicialCheckerContract;
use App\Domains\Cuenta\Exceptions\CannotFindCuentaException;

/**
 * Handler para el comando de actualización de cuentas.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Cuenta\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdateCuentaHandler
{
    public function __construct(
        private CuentaRepositoryContract $repository,
        private CuentaCanUpdateSaldoInicialCheckerContract $checker,
    ) {}

    public function __invoke(UpdateCuentaCommand $command)
    {
        $existing = $this->repository->findById($command->id);
        if (!$existing) {
            throw new CannotFindCuentaException(); 
        }

        $cuenta = $existing->updateData(
            nombre: $command->nombre,
            notas: $command->notas,
           saldo_inicial: $command->saldo_inicial,
            saldo_actual: $command->saldo_actual,
            tipo_cuenta_id: $command->tipo_cuenta_id,
            id: $command->id,
            checker: $this->checker,
        );

        return $this->repository->update($cuenta, $command->id);
    }
}