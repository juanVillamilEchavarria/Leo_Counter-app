<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\TipoMovimiento;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoReadRepositoryContract;
use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoRepositoryContract;
use App\Infrastructure\TipoMovimiento\Persistence\Repositories\Eloquent\EloquentTipoMovimientoReadRepository;
use App\Infrastructure\TipoMovimiento\Persistence\Repositories\Eloquent\EloquentTipoMovimientoRepository;

class TipoMovimientoRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(TipoMovimientoReadRepositoryContract::class, EloquentTipoMovimientoReadRepository::class);
        $this->app->singleton(TipoMovimientoRepositoryContract::class, EloquentTipoMovimientoRepository::class);
    }

}
