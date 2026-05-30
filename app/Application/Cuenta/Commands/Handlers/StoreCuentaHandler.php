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

use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Application\Cuenta\Commands\StoreCuentaCommand;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Shared\Domain\ValueObjects\Amount;
use App\Domains\Propietario\ValueObjects\PropietarioId;

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
        private CuentaRepositoryContract $repository,
        private IdGeneratorContract $idGenerator
    ) {}

    public function __invoke(StoreCuentaCommand $command)
    {
        $cuenta = Cuenta::create(
            id: CuentaId::generate($this->idGenerator),
            nombre: $command->nombre,
            notas: $command->notas,
            saldo_inicial: new Amount((float) $command->saldo_inicial),
            propietario_id: new PropietarioId($command->propietario_id),
            tipo_cuenta_id: $command->tipo_cuenta_id,
        );

        return $this->repository->store($cuenta);
    }
}
