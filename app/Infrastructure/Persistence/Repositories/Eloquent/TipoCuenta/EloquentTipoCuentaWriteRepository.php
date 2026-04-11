<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\TipoCuenta;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\TipoCuenta\Contracts\Repositories\TipoCuentaWriteRepositoryContract;
use App\Models\TipoCuenta\TipoCuenta;

class EloquentTipoCuentaWriteRepository extends EloquentWriteRepository implements TipoCuentaWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(TipoCuenta::class);
    }
}
