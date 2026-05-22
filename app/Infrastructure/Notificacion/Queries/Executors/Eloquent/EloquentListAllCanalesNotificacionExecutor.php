<?php

namespace App\Infrastructure\Notificacion\Queries\Executors\Eloquent;

use App\Application\Notificacion\Contracts\Queries\Executors\CanalNotificacionQueryExecutorContract;
use App\Application\Notificacion\Contracts\Queries\ListCanalesQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\Notificacion\CanalNotificacion as CanalModel;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

final readonly class EloquentListAllCanalesNotificacionExecutor implements CanalNotificacionQueryExecutorContract
{
    public function execute(ListCanalesQueryContract $query): CollectionContract
    {
        return new LaravelCollection(CanalModel::all());
    }
}
