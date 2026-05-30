<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
