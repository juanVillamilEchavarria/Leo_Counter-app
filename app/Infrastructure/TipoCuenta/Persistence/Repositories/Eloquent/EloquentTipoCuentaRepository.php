<?php

namespace App\Infrastructure\TipoCuenta\Persistence\Repositories\Eloquent;

use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\TipoCuenta\Contracts\Repositories\TipoCuentaRepositoryContract;
use App\Models\TipoCuenta\TipoCuenta;

class EloquentTipoCuentaRepository extends EloquentRepository implements TipoCuentaRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(TipoCuenta::class);
    }
}
