<?php

namespace App\Domains\Propietario\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\Propietario\Repositories\Contracts\PropietarioWriteRepositoryContract;
use App\Models\Propietario\Propietario;

class EloquentPropietarioWriteRepository extends EloquentWriteRepository implements PropietarioWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(Propietario::class);
    }
}
