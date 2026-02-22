<?php

namespace App\Domains\TipoCuenta\Repositories\Application\Eloquent;

use App\Domains\TipoCuenta\Repositories\Contracts\TipoCuentaReadRepositoryContract;
use App\Models\TipoCuenta\TipoCuenta;
use Illuminate\Database\Eloquent\Collection;

class EloquentTipoCuentaReadRepository implements TipoCuentaReadRepositoryContract
{
    public function getAll(): Collection
    {
        return TipoCuenta::all();
    }
}
