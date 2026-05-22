<?php

namespace App\Application\Notificacion\Contracts\Queries\Executors;

use App\Shared\Domain\Contracts\CollectionContract;
use App\Application\Notificacion\Contracts\Queries\ListCanalesQueryContract;

interface CanalNotificacionQueryExecutorContract
{
    public function execute(ListCanalesQueryContract $query): CollectionContract;
}
