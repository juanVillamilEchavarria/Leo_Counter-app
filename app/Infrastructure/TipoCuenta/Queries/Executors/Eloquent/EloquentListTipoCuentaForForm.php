<?php

namespace App\Infrastructure\TipoCuenta\Queries\Executors\Eloquent;

use App\Application\Cuenta\Contracts\Queries\Executors\FormOptions\ListTipoCuentaForFormContract;
use App\Models\TipoCuenta\TipoCuenta;
use App\Shared\Application\Contracts\Queries\QueryContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;


final readonly class EloquentListTipoCuentaForForm implements ListTipoCuentaForFormContract
{
    public function execute(QueryContract $query): CollectionContract
    {
        $tiposCuenta = TipoCuenta::all(['id', 'tipo_cuenta']);
        return new LaravelCollection($tiposCuenta);
    }
}