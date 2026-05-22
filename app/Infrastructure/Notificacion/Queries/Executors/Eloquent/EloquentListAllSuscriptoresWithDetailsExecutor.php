<?php

namespace App\Infrastructure\Notificacion\Queries\Executors\Eloquent;

use App\Application\Notificacion\Contracts\Queries\Executors\SuscriptorNotificacionQueryExecutorContract;
use App\Application\Notificacion\Contracts\Queries\ListSuscriptoresQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\Notificacion\SuscriptorNotificacion as SuscriptorModel;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

final readonly class EloquentListAllSuscriptoresWithDetailsExecutor implements SuscriptorNotificacionQueryExecutorContract
{
    public function execute(ListSuscriptoresQueryContract $query): CollectionContract
    {
        return new LaravelCollection(SuscriptorModel::with(['user','canal'])->get());
    }
}
