<?php

namespace App\Application\Movimiento\Commands\Handlers;
use App\Application\Movimiento\Commands\RegisterMovimientoFromMovimientoFijoCommand;
use App\Domains\Categoria\Aggregates\Categoria;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Events\AutomatedMovimientoRegistered;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Shared\Application\Contracts\Queries\Executors\GetTipoMovimientoNameQueryExecutorContract;
use App\Domains\MovimientoFijo\Events\AutomatedMovimientoFijoProcessed;

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
        private EventBus $eventBus,
        private IdGeneratorContract $idGenerator,
        private CuentaRepositoryContract $cuentaRepository,
        private CategoriaRepositoryContract $categoriaRepository,
        private GetTipoMovimientoNameQueryExecutorContract $tipoMovimientoName

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
        $cuenta = $this->cuentaRepository->findById($movimiento->getCuentaId());
        $tipoMovimientoName = $this->tipoMovimientoName->getName($movimiento->getTipoMovimientoId());
        /** @var Categoria $categoria */
        $categoria = $this->categoriaRepository->findById($movimiento->getCategoriaId());
        $this->movimientoRepositoryContract->store($movimiento);
        $this->eventBus->publish(new AutomatedMovimientoRegistered(
            movimiento: $movimiento,
            cuenta: $cuenta,
        ));
        $this->eventBus->publish(new AutomatedMovimientoFijoProcessed(
            movimientoFijo: $movimientoFijo,
            movimiento: $movimiento,
        ));
    }

}
