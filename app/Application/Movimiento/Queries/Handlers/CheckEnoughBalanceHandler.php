<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Queries\Handlers;

use App\Application\Movimiento\Queries\CheckEnoughBalanceQuery;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Shared\Domain\Services\Financial\BalanceCheckerService;

/**
 * Manejador para verificar si hay suficiente saldo en una cuenta.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CheckEnoughBalanceHandler
{
    public function __construct(
        private CuentaRepositoryContract $cuentaRepository,
        private BalanceCheckerService $balanceCheckerService
    )
    {
    }
    public function __invoke(CheckEnoughBalanceQuery $query): bool
    {
        $cuenta = $this->cuentaRepository->findById(new CuentaId($query->cuenta_id));
        return $this->balanceCheckerService->canAfford($cuenta->getSaldoActual(), $query->monto);
    }

}
