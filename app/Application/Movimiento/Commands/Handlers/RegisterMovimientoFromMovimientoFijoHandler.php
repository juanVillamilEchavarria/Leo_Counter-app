<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Commands\Handlers;
use App\Application\Movimiento\Commands\RegisterMovimientoFromMovimientoFijoCommand;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Manejador del comando para registrar un movimiento desde un movimiento fijo.
 * se utiliza principalmente en la automatizacion diaria.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Movimiento\Commands\Handlers
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class RegisterMovimientoFromMovimientoFijoHandler
{
    public function __construct(
        private MovimientoRepositoryContract $movimientoRepositoryContract,
        private IdGeneratorContract $idGenerator,
        private CuentaRepositoryContract $cuentaRepository,

    )
    {
    }

    public function __invoke(RegisterMovimientoFromMovimientoFijoCommand $command): void
    {
        $now = new Date(new \DateTimeImmutable());
        $movimientoFijo = $command->movimientoFijo;
        $movimiento = Movimiento::create(
            id: MovimientoId::generate($this->idGenerator),
            nombre: $movimientoFijo->getNombre(),
            cuenta_id: $movimientoFijo->getCuentaId(),
            categoria_id: $movimientoFijo->getCategoriaId(),
            tipo_movimiento_id: $movimientoFijo->getTipoMovimientoId(),
            monto: $movimientoFijo->getMonto(),
            fecha: $now,
            descripcion: $movimientoFijo->getDescripcion(),
        );
        $this->cuentaRepository->findById($movimiento->getCuentaId());
        $this->movimientoRepositoryContract->store($movimiento);
    }

}
