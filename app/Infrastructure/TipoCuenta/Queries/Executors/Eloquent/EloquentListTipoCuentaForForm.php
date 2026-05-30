<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\TipoCuenta\Queries\Executors\Eloquent;

use App\Application\Cuenta\Contracts\Queries\Executors\FormOptions\ListTipoCuentaForFormContract;
use App\Models\TipoCuenta\TipoCuenta;
use App\Shared\Application\Contracts\Queries\QueryContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;


final readonly class EloquentListTipoCuentaForForm implements ListTipoCuentaForFormContract
{
    public function execute(): CollectionContract
    {
        $tiposCuenta = TipoCuenta::all(['id', 'tipo_cuenta']);
        return new LaravelCollection($tiposCuenta);
    }
}