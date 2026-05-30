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

use App\Application\Notificacion\Contracts\Queries\Executors\SuscriptorNotificacionQueryExecutorContract;
use App\Application\Notificacion\Contracts\Queries\ListSuscriptoresQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\Notificacion\SuscriptorNotificacion as SuscriptorModel;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use App\Application\Notificacion\DTOs\SuscriptorForListDTO;

final readonly class EloquentListAllSuscriptoresWithDetailsExecutor implements SuscriptorNotificacionQueryExecutorContract
{
    public function execute(ListSuscriptoresQueryContract $query): CollectionContract
    {
       $records=  SuscriptorModel::with(['user','canal'])->get();
       $mapped = $records->map(function ($model){
           return new SuscriptorForListDTO(
               id: $model->id,
               usuario: $model->user->name,
               canal: $model->canal->nombre,
               active: $model->active,
               verified: $model->verified_at !== null ? true : false
           );
       });
       return new LaravelCollection($mapped);

    }
}
