<?php

namespace App\Infrastructure\MovimientoFijo\Persistence\Repositories\Eloquent;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo as MovimientoFijoAggregate;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;
use App\Models\MovimientoFijo\MovimientoFijo;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;

/**
 * Repositorio Eloquent del agregado MovimientoFijo.
 * Se encarga exclusivamente de persistir y reconstituir agregados sin exponer Eloquent al dominio.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\MovimientoFijo\Persistence\Repositories\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final class EloquentMovimientoFijoRepository extends EloquentRepository implements MovimientoFijoRepositoryContract
{
    protected array $toggeable = [
        'active',
        'registrar_automatico'
    ];

    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof MovimientoFijoAggregate, 'El agregado debe ser una instancia de MovimientoFijoAggregate');

        return [
            'id' => $aggregate->getId()->getValue(),
            'nombre' => $aggregate->getNombre(),
            'descripcion' => $aggregate->getDescripcion(),
            'tipo_movimiento_id' => $aggregate->getTipoMovimientoId(),
            'categoria_id' => $aggregate->getCategoriaId()->getValue(),
            'cuenta_id' => $aggregate->getCuentaId()->getValue(),
            'frecuencia_movimiento_id' => $aggregate->getFrecuenciaMovimientoId(),
            'monto' => $aggregate->getMonto(),
            'fecha_proximo' => $aggregate->getFechaProximo()->format('Y-m-d'),
            'dias_aviso' => $aggregate->getDiasAviso(),
            'active' => $aggregate->getActive(),
            'registrar_automatico' => $aggregate->getRegistrarAutomatico(),
        ];
    }

    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return MovimientoFijoAggregate::reconstitute(
            id: new MovimientoFijoId($model->id),
            categoria_id: new CategoriaId($model->categoria_id),
            cuenta_id: new CuentaId($model->cuenta_id),
            tipo_movimiento_id: (int) $model->tipo_movimiento_id,
            frecuencia_movimiento_id: (int) $model->frecuencia_movimiento_id,
            nombre: $model->nombre,
            monto: (float) $model->monto,
            fecha_proximo: new Date(new DateTimeImmutable((string) $model->fecha_proximo)),
            dias_aviso: $model->dias_aviso !== null ? (int) $model->dias_aviso : null,
            descripcion: $model->descripcion,
            active: (bool) $model->active,
            registrar_automatico: (bool) $model->registrar_automatico,
        );
    }

    public function __construct()
    {
        return parent::__construct(MovimientoFijo::class);
    }
}
