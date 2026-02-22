<?php

namespace App\Domains\MovimientoFijo\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\MovimientoFijo\Repositories\Contracts\MovimientoFijoWriteRepositoryContract;
use App\Models\MovimientoFijo\MovimientoFijo;

class EloquentMovimientoFijoWriteRepository extends EloquentWriteRepository implements MovimientoFijoWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(MovimientoFijo::class);
    }

    public function toggleActive(MovimientoFijo $movimientoFijo): bool
    {
        return $movimientoFijo->update(['active' => !$movimientoFijo->active]);
    }

    public function toggleRegistrarAutomaticamente(MovimientoFijo $movimientoFijo): bool
    {
        return $movimientoFijo->update(['registrar_automatico' => !$movimientoFijo->registrar_automatico]);
    }
}
