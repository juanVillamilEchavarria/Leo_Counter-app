<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;
use App\Shared\Abstracts\Actions\UpdateAction;

/** @method bool update(Presupuesto $model, \App\Domains\Presupuesto\DTOs\UpdatePresupuestoMesActualDTO $dto) */
class UpdatePresupuestoAction extends UpdateAction
{
    public function __construct()
    {
        parent::__construct(Presupuesto::class);
    }
}
