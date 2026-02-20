<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;
use App\Shared\Abstracts\Actions\DestroyAction;

/** @method bool destroy(Presupuesto $model) */
class DestroyPresupuestoAction extends DestroyAction
{
    public function __construct()
    {
        parent::__construct(Presupuesto::class);
    }
}
