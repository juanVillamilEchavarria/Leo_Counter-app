<?php

namespace App\Domains\TipoCuenta\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface TipoCuentaReadRepositoryContract
{
    public function getAll(): Collection;
}
