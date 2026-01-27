<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;

class DestroyPresupuestoAction
{
    public function destroy(Presupuesto $presupuesto): bool
    {
        return $presupuesto->delete();
    }
}
