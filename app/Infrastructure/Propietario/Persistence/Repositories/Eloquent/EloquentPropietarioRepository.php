<?php

namespace App\Infrastructure\Propietario\Persistence\Repositories\Eloquent;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Propietario\Contracts\Repositories\PropietarioRepositoryContract;
use App\Models\Propietario\Propietario;

class EloquentPropietarioRepository extends EloquentRepository implements PropietarioRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(Propietario::class);
    }
}
