<?php

namespace App\Domains\Categoria\Repositories\Application\Eloquent;

use App\Domains\Categoria\Repositories\Contracts\CategoriaReadRepositoryContract;
use App\Shared\Abstracts\Repositories\EloquentReadRepository;
use App\Models\Categoria\Categoria;
use Illuminate\Database\Eloquent\Collection;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

class EloquentCategoriaReadRepository extends EloquentReadRepository implements CategoriaReadRepositoryContract{
    protected array $forOptionsColumns = [
        'id',
        'nombre'
    ];

    public function __construct()
    {
        parent::__construct(Categoria::class);
    }
    public function getForOptionsByTipoMovimiento(TipoMovimientoEnum $tipo_movimiento): Collection
    {
        return $this->model::query()->select($this->forOptionsColumns)->where('tipo_movimiento_id', $tipo_movimiento->value)->get();
    }

    public function getAllByType(int $tipo_movimiento_id): \Illuminate\Database\Eloquent\Collection{
        return Categoria::where('tipo_movimiento_id', $tipo_movimiento_id)->get();
    }

    public function getEqual(string $nombre, int $tipo_movimiento_id): \Illuminate\Database\Eloquent\Builder{
        return Categoria::query()->where('nombre', $nombre)->where('tipo_movimiento_id', $tipo_movimiento_id);
    }

    public function getAllWithFullDetails(): \Illuminate\Database\Eloquent\Collection{
        return Categoria::with('tipoMovimiento')->get();
    }

}
