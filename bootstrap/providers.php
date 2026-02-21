<?php
use App\Domains\Movimiento\Repositories\Providers\MovimientoRepositoryProvider;
use App\Domains\Presupuesto\Repositories\Providers\PresupuestoRepositoryProvider;
use App\Domains\Cuenta\Repositories\Providers\CuentaRepositoryProvider;
use App\Domains\Categoria\Repositories\Providers\CategoriaRepositoryProvider;

return [
    MovimientoRepositoryProvider::class,
    PresupuestoRepositoryProvider::class,
    CuentaRepositoryProvider::class,
    CategoriaRepositoryProvider::class,
    App\Domains\Propietario\Repositories\Providers\PropietarioRepositoryProvider::class,
    App\Domains\TipoMovimiento\Repositories\Providers\TipoMovimientoRepositoryProvider::class,
    App\Domains\MovimientoFijo\Repositories\Providers\MovimientoFijoRepositoryProvider::class,
    App\Domains\MovimientoPendiente\Repositories\Providers\MovimientoPendienteRepositoryProvider::class,
    App\Providers\AppServiceProvider::class,
];
