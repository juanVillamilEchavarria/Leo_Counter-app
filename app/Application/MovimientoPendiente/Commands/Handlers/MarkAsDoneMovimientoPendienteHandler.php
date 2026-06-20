<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.1
 */
namespace App\Application\MovimientoPendiente\Commands\Handlers;

use App\Application\Movimiento\Commands\StoreMovimientoCommand;
use App\Application\Movimiento\Commands\Handlers\StoreMovimientoHandler;
use App\Application\MovimientoPendiente\Commands\MarkAsDoneMovimientoPendienteCommand;
use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Application\Events\AuditableActionOcurred;
use App\Domains\Auditoria\Enums\AuditableActions;
use App\Domains\Auditoria\Enums\AuditableTypes;
final readonly class MarkAsDoneMovimientoPendienteHandler
{
    public function __construct(
        private CommandBus $commandBus,
        private MovimientoPendienteRepositoryContract $movimientoPendienteRepository,
        private EventBus $eventBus
    )
    {
    }
    public function __invoke(MarkasDoneMovimientoPendienteCommand $command) : void
    {
        /**
         * @var MovimientoPendiente $movimientoPendiente
         */
        $movimientoPendiente = $this->movimientoPendienteRepository->findById(new MovimientoPendienteId($command->id));
        $oldMovimientoPendiente = $movimientoPendiente;
        $movimientoPendiente= $movimientoPendiente->markAsDone();
        $this->movimientoPendienteRepository->update($movimientoPendiente);

        $this->eventBus->publish(new AuditableActionOcurred(
            old_aggregate: $oldMovimientoPendiente,
            new_aggregate: $movimientoPendiente,
            action: AuditableActions::UPDATE,
            type: AuditableTypes::MOVIMIENTOS_PENDIENTES
        ));

        $this->commandBus->dispatch(new StoreMovimientoCommand(
            nombre: $movimientoPendiente->getNombre(),
            cuenta_id: $movimientoPendiente->getCuentaId()->getValue(),
            categoria_id: $movimientoPendiente->getCategoriaId()->getValue(),
            tipo_movimiento_id: $movimientoPendiente->getTipoMovimientoId()->value,
            monto: $movimientoPendiente->getMonto()->getValue(),
            descripcion: $movimientoPendiente->getDescripcion(),
            movimiento_pendiente_id: $movimientoPendiente->getId()->getValue(),
            comprobantes: $command->comprobantes
        ));

    }

}
