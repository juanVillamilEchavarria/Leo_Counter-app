<?php

namespace App\Domains\MovimientoFijo\Repositories\Application\Eloquent;

use App\Domains\MovimientoFijo\Repositories\Contracts\MovimientoFijoReadRepositoryContract;
use App\Shared\Abstracts\Repositories\EloquentReadRepository;
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
        return MovimientoFijo::with(['categoria','cuenta','frecuencia'])->get();
    }

}
