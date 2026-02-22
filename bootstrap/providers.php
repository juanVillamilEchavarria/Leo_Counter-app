<?php
use App\Domains\Movimiento\Repositories\Providers\MovimientoRepositoryProvider;
use App\Domains\Presupuesto\Repositories\Providers\PresupuestoRepositoryProvider;
use App\Domains\Cuenta\Repositories\Providers\CuentaRepositoryProvider;
use App\Domains\Categoria\Repositories\Providers\CategoriaRepositoryProvider;
use App\Domains\TipoCuenta\Repositories\Providers\TipoCuentaRepositoryProvider;
use App\Domains\FrecuenciaMovimiento\Repositories\Providers\FrecuenciaMovimientoRepositoryProvider;
use App\Domains\TipoPresupuesto\Repositories\Providers\TipoPresupuestoRepositoryProvider;
use App\Domains\ArchivoMovimiento\Repositories\Providers\ArchivoMovimientoRepositoryProvider;

return [
    MovimientoRepositoryProvider::class,
    PresupuestoRepositoryProvider::class,
    CuentaRepositoryProvider::class,
    CategoriaRepositoryProvider::class,
    App\Domains\Propietario\Repositories\Providers\PropietarioRepositoryProvider::class,
    App\Domains\TipoMovimiento\Repositories\Providers\TipoMovimientoRepositoryProvider::class,
    App\Domains\MovimientoFijo\Repositories\Providers\MovimientoFijoRepositoryProvider::class,
    App\Domains\MovimientoPendiente\Repositories\Providers\MovimientoPendienteRepositoryProvider::class,
    TipoCuentaRepositoryProvider::class,
    FrecuenciaMovimientoRepositoryProvider::class,
    TipoPresupuestoRepositoryProvider::class,
    ArchivoMovimientoRepositoryProvider::class,
    App\Providers\AppServiceProvider::class,
];
