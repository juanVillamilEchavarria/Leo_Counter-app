<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Notificacion\Queries\Executors\Eloquent;

use App\Application\Notificacion\Queries\Handlers\FormOptions\ListCanalNotificacionForFormContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\Notificacion\CanalNotificacion;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Executor de la consulta de canales para el formulario
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Notificacion\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListCanalNotificacionForFormQueryExecutor implements ListCanalNotificacionForFormContract
{

    /**
     * @inheritDoc
     */
    public function execute(): CollectionContract
    {
       $canales = CanalNotificacion::where('active', '=', true)->get();
       return new LaravelCollection($canales);
    }
}
