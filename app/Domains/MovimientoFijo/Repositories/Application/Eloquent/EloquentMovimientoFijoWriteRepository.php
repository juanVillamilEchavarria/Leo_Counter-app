<?php

namespace App\Domains\MovimientoFijo\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\MovimientoFijo\Repositories\Contracts\MovimientoFijoWriteRepositoryContract;
use App\Models\MovimientoFijo\MovimientoFijo;

class EloquentMovimientoFijoWriteRepository extends EloquentWriteRepository implements MovimientoFijoWriteRepositoryContract
{
    protected array $toggeable = [
        'active',
        'registrar_automatico'
    ];
    public function __construct()
    {
        return parent::__construct(MovimientoFijo::class);
    }

}
