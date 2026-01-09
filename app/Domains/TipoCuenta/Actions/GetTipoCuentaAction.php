<?php

namespace App\Domains\TipoCuenta\Actions;

use App\Models\TipoCuenta\TipoCuenta;
use Illuminate\Database\Eloquent\Collection;

class GetTipoCuentaAction
{
    public function getAll() : Collection
    {
        return TipoCuenta::all();
    }
}