<?php

namespace App\Infrastructure\MovimientoFijo\Persistence\Repositories\Eloquent;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;
use App\Models\MovimientoFijo\MovimientoFijo;

class EloquentMovimientoFijoRepository extends EloquentRepository implements MovimientoFijoRepositoryContract
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
