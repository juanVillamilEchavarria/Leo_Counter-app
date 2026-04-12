<?php

namespace App\Infrastructure\TipoCuenta\Persistence\Repositories\Eloquent;

use App\Domains\TipoCuenta\Contracts\Repositories\TipoCuentaReadRepositoryContract;
use App\Models\TipoCuenta\TipoCuenta;
use Illuminate\Database\Eloquent\Collection;

class EloquentTipoCuentaReadRepository implements TipoCuentaReadRepositoryContract
{
    public function getAll(): Collection
    {
        return TipoCuenta::all();
    }
}
