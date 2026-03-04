<?php

return [
    App\Domains\ArchivoMovimiento\Repositories\Providers\ArchivoMovimientoRepositoryProvider::class,
    App\Domains\Categoria\Repositories\Providers\CategoriaRepositoryProvider::class,
    App\Domains\Cuenta\Repositories\Providers\CuentaRepositoryProvider::class,
    App\Domains\FrecuenciaMovimiento\Repositories\Providers\FrecuenciaMovimientoRepositoryProvider::class,
    App\Domains\MovimientoFijo\Repositories\Providers\MovimientoFijoRepositoryProvider::class,
    App\Domains\MovimientoPendiente\Repositories\Providers\MovimientoPendienteRepositoryProvider::class,
    App\Domains\Movimiento\Repositories\Providers\MovimientoRepositoryProvider::class,
    App\Domains\Presupuesto\Repositories\Providers\PresupuestoRepositoryProvider::class,
    App\Domains\Propietario\Repositories\Providers\PropietarioRepositoryProvider::class,
    App\Domains\Reporte\Repositories\Providers\ReporteProvider::class,
    App\Domains\TipoCuenta\Repositories\Providers\TipoCuentaRepositoryProvider::class,
    App\Domains\TipoMovimiento\Repositories\Providers\TipoMovimientoRepositoryProvider::class,
    App\Domains\TipoPresupuesto\Repositories\Providers\TipoPresupuestoRepositoryProvider::class,
    App\Providers\AppServiceProvider::class,
];
