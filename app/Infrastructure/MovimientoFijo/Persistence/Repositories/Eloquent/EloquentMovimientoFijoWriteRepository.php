<?php

namespace App\Infrastructure\MovimientoFijo\Persistence\Repositories\Eloquent;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoWriteRepositoryContract;
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
