<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\Propietario;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\Propietario\Contracts\Repositories\PropietarioWriteRepositoryContract;
use App\Models\Propietario\Propietario;

class EloquentPropietarioWriteRepository extends EloquentWriteRepository implements PropietarioWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(Propietario::class);
    }
}
