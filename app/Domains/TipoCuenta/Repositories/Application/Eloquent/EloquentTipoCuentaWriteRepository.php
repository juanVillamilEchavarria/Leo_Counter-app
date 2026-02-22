<?php

namespace App\Domains\TipoCuenta\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\TipoCuenta\Repositories\Contracts\TipoCuentaWriteRepositoryContract;
use App\Models\TipoCuenta\TipoCuenta;

class EloquentTipoCuentaWriteRepository extends EloquentWriteRepository implements TipoCuentaWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(TipoCuenta::class);
    }
}
