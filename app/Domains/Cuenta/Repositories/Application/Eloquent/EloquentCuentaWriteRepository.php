<?php

namespace App\Domains\Cuenta\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\Cuenta\Repositories\Contracts\CuentaWriteRepositoryContract;
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