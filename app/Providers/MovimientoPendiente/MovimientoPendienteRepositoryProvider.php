<?php

// ┌──────────────────────────────────────────────────────────────────────────┐
// │ ARCHIVO OBSOLETO — Comentado completamente tras el refactor CQRS/DDD   │
// │ del módulo MovimientoPendiente.                                         │
// │                                                                         │
// │ Los bindings han sido reemplazados por:                                  │
// │  - MovimientoPendienteServiceProvider (repositorio + form options)       │
// │  - MovimientoPendienteBusProvider (mapeo de comandos)                    │
// │  - MovimientoPendienteQueryExecutorServiceProvider (query executors)     │
// │                                                                         │
// │ NO ELIMINAR hasta que se confirme la estabilidad del refactor.          │
// └──────────────────────────────────────────────────────────────────────────┘

// namespace App\Providers\MovimientoPendiente;
//
// use Illuminate\Support\ServiceProvider;
// use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteReadRepositoryContract;
// use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
// use App\Infrastructure\MovimientoPendiente\Persistence\Repositories\Eloquent\EloquentMovimientoPendienteReadRepository;
// use App\Infrastructure\MovimientoPendiente\Persistence\Repositories\Eloquent\EloquentMovimientoPendienteRepository;
//
// class MovimientoPendienteRepositoryProvider extends ServiceProvider {
//
//     public function register(): void
//     {
//         $this->app->bind(MovimientoPendienteReadRepositoryContract::class, EloquentMovimientoPendienteReadRepository::class);
//         $this->app->singleton(MovimientoPendienteRepositoryContract::class, EloquentMovimientoPendienteRepository::class);
//     }
//
// }
