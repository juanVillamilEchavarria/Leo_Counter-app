<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;
use App\Shared\Abstracts\Actions\StoreAction;

/** @method Presupuesto store(\App\Domains\Presupuesto\DTOs\StorePresupuestoMesActualDTO $dto) */
class StorePresupuestoAction extends StoreAction
{
    public function __construct()
    {
        parent::__construct(Presupuesto::class);
    }
}