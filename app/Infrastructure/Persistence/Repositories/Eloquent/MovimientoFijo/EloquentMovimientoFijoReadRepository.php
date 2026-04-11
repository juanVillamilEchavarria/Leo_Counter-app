<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\MovimientoFijo;

use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoReadRepositoryContract;
use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentReadRepository;
use App\Models\MovimientoFijo\MovimientoFijo;

class EloquentMovimientoFijoReadRepository extends EloquentReadRepository implements MovimientoFijoReadRepositoryContract {

    public function __construct()
    {
        parent::__construct(MovimientoFijo::class);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection{
        return MovimientoFijo::all();
    }

    public function getAllWithDetails(): \Illuminate\Database\Eloquent\Collection{
        return MovimientoFijo::with(['categoria','cuenta','frecuencia_movimiento'])->get();
    }

}
