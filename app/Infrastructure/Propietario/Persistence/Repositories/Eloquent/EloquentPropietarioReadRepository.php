<?php

namespace App\Infrastructure\Propietario\Persistence\Repositories\Eloquent;

use App\Domains\Propietario\Contracts\Repositories\PropietarioReadRepositoryContract;
use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentReadRepository;
use App\Models\Propietario\Propietario;

class EloquentPropietarioReadRepository extends EloquentReadRepository implements PropietarioReadRepositoryContract {

    public function __construct()
    {
        parent::__construct(Propietario::class);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection{
        return Propietario::all();
    }

    public function getAllWithFullDetails(): \Illuminate\Database\Eloquent\Collection{
        return Propietario::with('cuentas:id,nombre,propietario_id')->get();
    }

}
