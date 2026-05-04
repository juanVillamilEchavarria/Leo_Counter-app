<?php

namespace App\Infrastructure\Categoria\Persistence\Repositories\Eloquent;

use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Models\Categoria\Categoria;
use App\Domains\Categoria\Aggregates\Categoria as CategoriaAggregate;
use App\Shared\Domain\Contracts\AggregateModelContract;
use Illuminate\Database\Eloquent\Model;

class EloquentCategoriaRepository extends EloquentRepository implements CategoriaRepositoryContract
{
    protected array $toggeable = [
        'es_fijo'
    ];

    /**
     * @param CategoriaAggregate $aggregate
     */
    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof CategoriaAggregate, 'El argumento debe ser una instancia de CategoriaAggregate');
        return [
            'nombre' => $aggregate->getNombre(),
            'tipo_movimiento_id' => $aggregate->getTipoMovimientoId(),
            'descripcion' => $aggregate->getDescripcion()
        ];
    }

    /**
     * @param Categoria $model
      * @return CategoriaAggregate
     */
    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return CategoriaAggregate::reconstitute(
            nombre: $model->nombre,
            tipo_movimiento_id: $model->tipo_movimiento_id,
            descripcion: $model->descripcion
        );
    }

    public function __construct()
    {
        return parent::__construct(Categoria::class);
    }
}
