<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Commands\Handlers;

use App\Application\Movimiento\Commands\RegisterMovimientoFromMovimientoFijoCommand;
use App\Application\MovimientoPendiente\Commands\RegisterMovimientoPendienteFromMovimientoFijoCommand;
use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Domains\MovimientoPendiente\Events\MovimientoPendienteCreatedFromMovimientoFijo;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Domains\MovimientoFijo\Events\MovimientoFijoCreatedAMovimientoPendiente;
final readonly class RegisterMovimientoPendienteFromMovimientoFijoHandler
{
    public function __construct(
        private MovimientoPendienteRepositoryContract $movimientoPendienteRepositoryContract,
        private IdGeneratorContract $idGeneratorContract,
        private EventBus $eventBus
    )
    {
    }
    public function __invoke( RegisterMovimientoPendienteFromMovimientoFijoCommand $command): void
    {
        $movimientoFijo = $command->movimientoFijo;
        $newDate = $movimientoFijo->getFechaProximo()->addDays();
        $movimientoPendiente = MovimientoPendiente::create(
            id: MovimientoPendienteId::generate($this->idGeneratorContract),
            categoria_id: $movimientoFijo->getCategoriaId(),
            cuenta_id: $movimientoFijo->getCuentaId(),
            tipo_movimiento_id: $movimientoFijo->getTipoMovimientoId(),
            nombre: $movimientoFijo->getNombre(),
            monto: $movimientoFijo->getMonto(),
            fecha_programada: $newDate,
            dias_aviso: null,
            descripcion: $movimientoFijo->getDescripcion(),
            movimiento_fijo_id: $movimientoFijo->getId()
        );
        $this->movimientoPendienteRepositoryContract->store($movimientoPendiente);
        $this->eventBus->publish(new MovimientoPendienteCreatedFromMovimientoFijo(
            movimientoPendiente: $movimientoPendiente,
            movimientoFijo: $movimientoFijo

        ));
    }

}
