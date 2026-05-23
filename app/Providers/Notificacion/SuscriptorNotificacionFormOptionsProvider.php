<?php

namespace App\Providers\Notificacion;

use Illuminate\Support\ServiceProvider;
use App\Application\Notificacion\Queries\Handlers\FormOptions\ListCanalNotificacionForFormContract;
use App\Infrastructure\Notificacion\Queries\Executors\Eloquent\EloquentListCanalNotificacionForFormQueryExecutor;
class SuscriptorNotificacionFormOptionsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ListCanalNotificacionForFormContract::class, EloquentListCanalNotificacionForFormQueryExecutor::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
