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

use App\Application\Cuenta\Commands\UpdateCuentaCommand;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Cuenta\Contracts\CuentaCanUpdateSaldoInicialCheckerContract;
use App\Domains\Cuenta\Exceptions\CannotFindCuentaException;
use App\Domains\Cuenta\ValueObjects\CuentaId;

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
        $existing = $this->repository->findById(new CuentaId($command->id));
        if (!$existing) {
            throw new CannotFindCuentaException();
        }

        $cuenta = $existing->updateData(
            nombre: $command->nombre,
            notas: $command->notas,
           saldo_inicial: $command->saldo_inicial,
            saldo_actual: $existing->getSaldoActual(),
            tipo_cuenta_id: $command->tipo_cuenta_id,
            propietario_id: $command->propietario_id,
            id: new CuentaId($command->id),
            checker: $this->checker,
        );

        return $this->repository->update($cuenta);
    }
}
