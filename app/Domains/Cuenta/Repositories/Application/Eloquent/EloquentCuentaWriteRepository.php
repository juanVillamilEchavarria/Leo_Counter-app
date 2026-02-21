<?php

namespace App\Domains\Cuenta\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\Cuenta\Repositories\Contracts\CuentaWriteRepositoryContract;
use App\Models\Cuenta\Cuenta;
use App\Domains\Cuenta\Exceptions\CannotUpdateCuentaException;
class EloquentCuentaWriteRepository extends EloquentWriteRepository implements CuentaWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(Cuenta::class);
    }

     public function toggleActive(Cuenta $cuenta): bool{
        if(!$cuenta){
            throw new CannotUpdateCuentaException;
        }
        return $cuenta->update(['active' => !$cuenta->active] );
    }
}