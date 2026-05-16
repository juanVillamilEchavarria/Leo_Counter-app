<?php

namespace App\Application\Movimiento\Commands\Handlers;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Application\Movimiento\Commands\DestroyMovimientoCommand;
use App\Application\Movimiento\Contracts\Queries\Executors\GetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract;
use App\Domains\Movimiento\Events\MovimientoDeleted;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Shared\Application\Contracts\Services\AuthServiceContract;
use App\Domains\Movimiento\Exceptions\CannotDeleteMovimientoException;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Shared\Application\Contracts\Bus\EventBus;

/**
 * Manejador del caso de uso de eliminar un movimiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Movimiento\Commands\Handlers
 * @version 1.0.0
 */
final readonly class DestroyMovimientoHandler
{
    public function __construct(
        private MovimientoRepositoryContract $movimientoRepository,
        private EventBus $eventBus,
        private CuentaRepositoryContract $cuentaRepository,
        private GetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract $getAllArchivoMovimientosIdsForAMovimientoQueryExecutor,
        private AuthServiceContract $authService
    )
    {
    }
    public function __invoke( DestroyMovimientoCommand $command) : void
    {
        if(!$this->authService->verifyPasswordForLoggedInUser($command->attempt_password)) throw new CannotDeleteMovimientoException("No se pudo eliminar el movimiento. Contraseña incorrecta");
        $archivoMovimientosIds = $this->getAllArchivoMovimientosIdsForAMovimientoQueryExecutor->execute(new MovimientoId($command->id));
        /**
         * @var Movimiento $movimiento
         */
        $movimiento = $this->movimientoRepository->findById(new MovimientoId($command->id));
        $cuenta = $this->cuentaRepository->findById($movimiento->getCuentaId());
        $this->eventBus->publish(new MovimientoDeleted(
            movimiento: $movimiento,
            oldMovimiento: $movimiento,
            cuenta: $cuenta,
            comprobantes_delete_ids: $archivoMovimientosIds->toArray(),
        ));
        $this->movimientoRepository->destroy($movimiento->getId());
    }

}

