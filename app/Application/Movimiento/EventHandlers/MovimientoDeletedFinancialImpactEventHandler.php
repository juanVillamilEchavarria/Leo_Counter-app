<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\EventHandlers;

use App\Domains\Movimiento\Events\MovimientoDeleted;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use  App\Application\Movimiento\Resolvers\RevertTransactionEffectForCuentaResolver;

/**
 * Manejador del impacto financiero de un movimiento cuando este es eliminado.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Movimiento\EventHandlers
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class MovimientoDeletedFinancialImpactEventHandler
{
    public function __construct(
        private RevertTransactionEffectForCuentaResolver $revertResolver,
        private CuentaRepositoryContract $cuentaRepository
    )
    {
    }
    public function __invoke(MovimientoDeleted $event): void
    {
       $movimiento = $event->getMovimiento();
       $cuenta = $this->cuentaRepository->findById($movimiento->getCuentaId());
       $cuenta = $this->revertResolver->resolve($movimiento, $cuenta);
       $this->cuentaRepository->update($cuenta);
    }

}
