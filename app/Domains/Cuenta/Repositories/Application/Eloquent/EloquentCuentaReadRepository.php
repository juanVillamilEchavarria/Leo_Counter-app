<?php

namespace App\Domains\Cuenta\Repositories\Application\Eloquent;

use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
use App\Shared\Abstracts\Repositories\EloquentReadRepository;
use App\Models\Cuenta\Cuenta;

class EloquentCuentaReadRepository extends EloquentReadRepository implements CuentaReadRepositoryContract{

    public function __construct()
    {
        parent::__construct(Cuenta::class);
    }

}
