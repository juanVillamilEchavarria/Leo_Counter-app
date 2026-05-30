<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Movimiento\Strategies\Transaction\Apply;

use App\Application\Movimiento\Contracts\Commands\WriteMovimientoCommandContract;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Strategies\ApplyTransactionEffectForCuentaStrategyContract;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Application\Movimiento\Commands\Abstracts\WriteMovimientoCommand;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

/**
 * Implementacion de la estrategia para aplicar el efecto de un gasto cuando un movimiento es escrito
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ApplyGastoEffectForCuentaStrategy implements ApplyTransactionEffectForCuentaStrategyContract
{


    public function supports(Movimiento $movimiento): bool
    {
        return $movimiento->getTipoMovimientoId()=== TipoMovimientoEnum::GASTO;
    }

    /**
     * @inheritDoc
     */
    public function applyTransactionEffectWhenAMovimientoIsWritten(Movimiento $movimiento, Cuenta $cuenta): Cuenta
    {
        $cuenta = $cuenta->updateSaldoActual($cuenta->getSaldoActual() - $movimiento->getMonto()->getValue());
        return $cuenta ;
    }
}
