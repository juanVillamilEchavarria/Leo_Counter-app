<?php

namespace App\Providers\Notificacion;

use Illuminate\Support\ServiceProvider;
use App\Domains\Notificacion\Contracts\Repositories\CanalRepositoryContract;
use App\Infrastructure\Notificacion\Persistence\Repositories\Eloquent\EloquentCanalRepository;
use App\Domains\Notificacion\Contracts\Repositories\SuscriptorRepositoryContract;
use App\Infrastructure\Notificacion\Persistence\Repositories\Eloquent\EloquentSuscriptorRepository;
use App\Domains\Notificacion\Contracts\SuscriptorUniquenessCheckerContract;
use App\Infrastructure\Notificacion\Persistence\Checkers\Eloquent\EloquentSuscriptorUniquenessChecker;
use App\Application\Notificacion\Contracts\Queries\Executors\CanalNotificacionQueryExecutorContract;
use App\Infrastructure\Notificacion\Queries\Executors\Eloquent\EloquentListAllCanalesNotificacionExecutor;
use App\Application\Notificacion\Contracts\Queries\Executors\SuscriptorNotificacionQueryExecutorContract;
use App\Infrastructure\Notificacion\Queries\Executors\Eloquent\EloquentListAllSuscriptoresWithDetailsExecutor;

class NotificacionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CanalRepositoryContract::class, EloquentCanalRepository::class);
        $this->app->singleton(SuscriptorRepositoryContract::class, EloquentSuscriptorRepository::class);
        $this->app->singleton(SuscriptorUniquenessCheckerContract::class, EloquentSuscriptorUniquenessChecker::class);

        $this->app->singleton(CanalNotificacionQueryExecutorContract::class, EloquentListAllCanalesNotificacionExecutor::class);
        $this->app->singleton(SuscriptorNotificacionQueryExecutorContract::class, EloquentListAllSuscriptoresWithDetailsExecutor::class);
    }

    public function boot(): void
    {
        //
    }
}
