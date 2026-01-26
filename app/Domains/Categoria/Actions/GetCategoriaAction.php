<?php

namespace App\Domains\Categoria\Actions;

use App\Models\Categoria\Categoria;
use Illuminate\Database\Eloquent\Collection;
use App\Domains\Categoria\Resources\CategoriaResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetCategoriaAction
{
    public function getAll() : Collection
    {
        return Categoria::all();
    }

    public function getAllByType(int $tipo_movimiento_id) : Collection {
        return Categoria::where('tipo_movimiento_id', $tipo_movimiento_id)->get();
    }

    public function getRecordsCount() : int{
        return Categoria::count();
    }

    public function getAllWithFullDetails() : Collection
    {
        return Categoria::with('tipoMovimiento')->get();
    }
    public function getAllWithDetails() : AnonymousResourceCollection
    {
        $categoria = $this->getAllWithFullDetails();
        return CategoriaResource::collection($categoria);
    }
}
