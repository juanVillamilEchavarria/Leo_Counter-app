<?php

namespace App\Application\Movimiento\Commands\Handlers;

use App\Application\Movimiento\Commands\StoreMovimientoCommand;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\Contracts\CuentaRepositoryContract;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;

/**
 * Manejador para el almacenamiento de un movimiento.
 */
final readonly class StoreMovimientoHandler
{
    public function __construct(
        private CuentaRepositoryContract $cuentaRepository,
        private IdGeneratorContract $idGenerator,
        private EventBus $eventBus,
        private MovimientoRepositoryContract $movimientoRepository
    )
    {
    }

    public function __invoke(StoreMovimientoCommand $command): void
    {
        $cuenta = $this->cuentaRepository->findById(new CuentaId($command->cuenta_id));
        $movimiento = Movimiento::create(
            id: MovimientoId::generate($this->idGenerator),
            nombre: $command->nombre,
            cuenta_id: $cuenta->getId(),
            categoria_id: new CategoriaId($command->categoria_id),
            tipo_movimiento_id: TipoMovimientoEnum::try($command->tipo_movimiento_id),
            monto: new Amount($command->monto),
            fecha: new Date(new DateTimeImmutable()),
            descripcion: $command->descripcion
        );
        
        $this->movimientoRepository->store($movimiento);

        $this->eventBus->publish(new \App\Application\Movimiento\Events\AttachmentsForMovimientoCreated(
            movimiento: $movimiento,
            comprobantes: $command->comprobantes
        ));
    }
}
