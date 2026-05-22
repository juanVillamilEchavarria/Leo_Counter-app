<?php

namespace App\Application\Notificacion\Queries\Handlers;

use App\Application\Notificacion\Queries\ListAllCanalesNotificacionQuery;
use App\Application\Notificacion\Contracts\Queries\Executors\CanalNotificacionQueryExecutorContract;
use App\Shared\Domain\Contracts\CollectionContract;

final readonly class ListAllCanalesNotificacionHandler
{
    public function __construct(
        private CanalNotificacionQueryExecutorContract $executor
    ){}

    public function __invoke(ListAllCanalesNotificacionQuery $query): CollectionContract
    {
        return $this->executor->execute($query);
    }
}
