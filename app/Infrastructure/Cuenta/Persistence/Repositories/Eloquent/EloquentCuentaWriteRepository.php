<?php

namespace App\Infrastructure\Cuenta\Persistence\Repositories\Eloquent;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\Cuenta\Contracts\Repositories\CuentaWriteRepositoryContract;
use App\Models\Cuenta\Cuenta;

class EloquentCuentaWriteRepository extends EloquentWriteRepository implements CuentaWriteRepositoryContract
{
    protected array $toggeable = [
        'active'
    ];

    public function __construct()
    {
        return parent::__construct(Cuenta::class);
    }
}