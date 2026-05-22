<?php

namespace App\Application\Notificacion\Contracts\Queries\Executors;

use App\Shared\Domain\Contracts\CollectionContract;
use App\Application\Notificacion\Contracts\Queries\ListSuscriptoresQueryContract;

interface SuscriptorNotificacionQueryExecutorContract
{
    public function execute(ListSuscriptoresQueryContract $query): CollectionContract;
}
