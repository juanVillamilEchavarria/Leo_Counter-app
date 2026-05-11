<?php

namespace App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent;

use App\Domains\MovimientoPendiente\Contracts\GetAllAccountsBalanceForMovimientosPendientesContract;
use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

class EloquentGetAllAccountsBalanceForMovimientosPendientesQueryExecutor implements GetAllAccountsBalanceForMovimientosPendientesContract
{

    /**
     * @inheritDoc
     */
    public function getAllAccountsBalanceForMovimientosPendientes(): \App\Shared\Domain\Contracts\CollectionContract
    {
        $accountsBalance= MovimientoPendiente::query()
            ->select('cuentas.id', 'cuentas.saldo_actual')
            ->leftJoin('cuentas', 'cuentas.id', '=', 'movimiento_pendientes.cuenta_id')
            ->where('movimiento_pendientes.tipo_movimiento_id', TipoMovimientoEnum::GASTO->value)
            ->groupBy('cuentas.id', 'cuentas.saldo_actual')
            ->get();
        return LaravelCollection::make($accountsBalance);
    }
}
