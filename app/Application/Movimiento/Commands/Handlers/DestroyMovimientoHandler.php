<?php

namespace App\Application\Movimiento\Commands\Handlers;

use App\Application\Movimiento\Commands\DestroyMovimientoCommand;
use App\Application\Movimiento\Contracts\Queries\Executors\GetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract;
use App\Application\Movimiento\Events\AttachmentsForMovimientoDeleted;
use App\Domains\Cuenta\Contracts\CuentaRepositoryContract;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Domains\Movimiento\Exceptions\CannotDeleteMovimientoException;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Application\Contracts\Services\AuthServiceContract;

/**
 * Manejador del caso de uso de eliminar un movimiento
 */
final readonly class DestroyMovimientoHandler
{
    public function __construct(
        private MovimientoRepositoryContract $movimientoRepository,
        private EventBus $eventBus,
        private GetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract $getAllArchivoMovimientosIdsForAMovimientoQueryExecutor,
        private AuthServiceContract $authService
    )
    {
    }
    public function __invoke( DestroyMovimientoCommand $command) : void
    {
        if(!$this->authService->verifyPasswordForLoggedInUser($command->attempt_password)) throw new CannotDeleteMovimientoException("No se pudo eliminar el movimiento. Contraseña incorrecta");
        $archivoMovimientosIds = $this->getAllArchivoMovimientosIdsForAMovimientoQueryExecutor->execute(new MovimientoId($command->id));
        /** @var Movimiento $movimiento */
        $movimiento = $this->movimientoRepository->findById(new MovimientoId($command->id));
        // Publicar evento de aplicación ANTES para eliminar comprobantes asociados, pues la tabla de archivo movimientos tiene onDelete cascade
        $this->eventBus->publish(new AttachmentsForMovimientoDeleted(
            movimiento: $movimiento,
            comprobantes_delete_ids: $archivoMovimientosIds->toArray(),
        ));
        // El repositorio se encarga de publicar el evento de dominio MovimientoDeleted
        $this->movimientoRepository->destroy($movimiento->getId());


    }
}
