<?php

namespace App\Infrastructure\Cuenta\Persistence\Repositories\Eloquent;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Models\Cuenta\Cuenta;

class EloquentCuentaRepository extends EloquentRepository implements CuentaRepositoryContract
{
    protected array $toggeable = [
        'active'
    ];

    public function __construct()
    {
        return parent::__construct(Cuenta::class);
    }
}