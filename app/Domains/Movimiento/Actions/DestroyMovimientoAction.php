<?php

namespace App\Domains\Movimiento\Actions;

use App\Shared\Abstracts\Actions\DestroyAction;
use App\Models\Movimiento\Movimiento;

/** @method Movimiento destroy(Movimiento $model) */
class DestroyMovimientoAction extends DestroyAction{
    public function __construct()
    {
        return parent::__construct(Movimiento::class);
    }

}