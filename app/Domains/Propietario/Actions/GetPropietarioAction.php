<?php
namespace App\Domains\Propietario\Actions;

use App\Models\Propietario\Propietario;
use Illuminate\Database\Eloquent\Collection;

class GetPropietarioAction
{
    public function getAll() : Collection
    {
        return Propietario::all();
    }

    public function getRecordsCount() : int{
        return Propietario::count();
    }
}