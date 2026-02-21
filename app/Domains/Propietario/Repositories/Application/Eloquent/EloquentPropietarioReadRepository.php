<?php

namespace App\Domains\Propietario\Repositories\Application\Eloquent;

use App\Domains\Propietario\Repositories\Contracts\PropietarioReadRepositoryContract;
use App\Shared\Abstracts\Repositories\EloquentReadRepository;
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
