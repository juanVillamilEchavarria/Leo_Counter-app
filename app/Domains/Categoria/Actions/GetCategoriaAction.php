<?php

namespace App\Domains\Categoria\Actions;

use App\Models\Categoria\Categoria;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class GetCategoriaAction
{
    public function getAll() : Collection
    {
        return Categoria::all();
    }


    public function getAllByType(int $tipo_movimiento_id) : Collection {
        return Categoria::where('tipo_movimiento_id', $tipo_movimiento_id)->get();
    }

    public function getEqual(string $nombre, int $tipo_movimiento_id) : Builder {
        return Categoria::where('nombre', $nombre)->where('tipo_movimiento_id', $tipo_movimiento_id);
    }
    public function getRecordsCount() : int{
        return Categoria::count();
    }

    public function getAllWithFullDetails() : Collection
    {
        return Categoria::with('tipoMovimiento')->get();
    }
}
