<?php

namespace App\Application\Notificacion\Queries\Handlers;

use App\Application\Notificacion\Queries\ListAllSuscriptoresWithDetailsQuery;
use App\Application\Notificacion\Contracts\Queries\Executors\SuscriptorNotificacionQueryExecutorContract;
use App\Shared\Domain\Contracts\CollectionContract;

final readonly class ListAllSuscriptoresWithDetailsHandler
{
    public function __construct(
        private SuscriptorNotificacionQueryExecutorContract $executor
    ){
    }

    public function __invoke(ListAllSuscriptoresWithDetailsQuery $query): CollectionContract
    {
        return $this->executor->execute($query);
    }
}
