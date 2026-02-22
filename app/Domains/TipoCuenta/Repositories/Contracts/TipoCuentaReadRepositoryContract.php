<?php

namespace App\Domains\TipoCuenta\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TipoCuentaReadRepositoryContract
{
    public function getAll(): Collection;
}
