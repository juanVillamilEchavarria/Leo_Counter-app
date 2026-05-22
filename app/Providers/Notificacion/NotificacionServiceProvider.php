<?php

namespace App\Providers\Notificacion;

use Illuminate\Support\ServiceProvider;
use App\Domains\Notificacion\Contracts\Repositories\CanalNotificacionRepositoryContract;
use App\Infrastructure\Notificacion\Persistence\Repositories\Eloquent\EloquentCanalNotificacionRepository;
use App\Domains\Notificacion\Contracts\Repositories\SuscriptorNotificacionRepositoryContract;
use App\Infrastructure\Notificacion\Persistence\Repositories\Eloquent\EloquentSuscriptorNotificacionRepository;
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
        $this->app->singleton(CanalNotificacionRepositoryContract::class, EloquentCanalNotificacionRepository::class);
        $this->app->singleton(SuscriptorNotificacionRepositoryContract::class, EloquentSuscriptorNotificacionRepository::class);
        $this->app->singleton(SuscriptorUniquenessCheckerContract::class, EloquentSuscriptorUniquenessChecker::class);

        $this->app->singleton(CanalNotificacionQueryExecutorContract::class, EloquentListAllCanalesNotificacionExecutor::class);
        $this->app->singleton(SuscriptorNotificacionQueryExecutorContract::class, EloquentListAllSuscriptoresWithDetailsExecutor::class);
    }

    public function boot(): void
    {
        //
    }
}
