<?php

namespace App\Application\Movimiento\Commands\Handlers;
use App\Application\Movimiento\Resolvers\RevertTransactionEffectForCuentaResolver;
use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Application\ArchivoMovimiento\Commands\DestroyArchivoMovimientoCommand;
use App\Application\Movimiento\Commands\DestroyMovimientoCommand;
use App\Application\Movimiento\Contracts\Queries\Executors\GetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Shared\Application\Contracts\Services\AuthServiceContract;
use App\Domains\Movimiento\Exceptions\CannotDeleteMovimientoException;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;

final readonly class DestroyMovimientoHandler
{
    public function __construct(
        private MovimientoRepositoryContract $movimientoRepository,
        private CuentaRepositoryContract $cuentaRepository,
        private RevertTransactionEffectForCuentaResolver $revertTransactionEffectForCuentaResolver,
        private CommandBus $commandBus,
        private GetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract $getAllArchivoMovimientosIdsForAMovimientoQueryExecutor,
        private AuthServiceContract $authService
    )
    {
    }
    public function __invoke( DestroyMovimientoCommand $command) : void
    {
        if(!$this->authService->verifyPasswordForLoggedInUser($command->attempt_password)) throw new CannotDeleteMovimientoException("No se pudo eliminar el movimiento. Contraseña incorrecta");
        $archivoMovimientosIds = $this->getAllArchivoMovimientosIdsForAMovimientoQueryExecutor->execute(new MovimientoId($command->id));
        /** @var ArchivoMovimientoId $archivoMovimientoId */
        foreach ($archivoMovimientosIds as $archivoMovimientoId) {
            $this->commandBus->dispatch(new DestroyArchivoMovimientoCommand($archivoMovimientoId));
        }
        /**
         * @var Movimiento $movimiento
         */
        $movimiento = $this->movimientoRepository->findById(new MovimientoId($command->id));
        $cuenta = $this->cuentaRepository->findById($movimiento->getCuentaId());
        $this->revertTransactionEffectForCuentaResolver->resolve($command,$movimiento, $cuenta);
        $this->cuentaRepository->update($cuenta);
        $this->movimientoRepository->destroy($movimiento->getId());
    }

}
