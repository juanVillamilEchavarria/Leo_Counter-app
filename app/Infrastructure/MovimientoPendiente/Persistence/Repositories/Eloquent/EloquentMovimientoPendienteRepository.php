<?php

namespace App\Infrastructure\MovimientoPendiente\Persistence\Repositories\Eloquent;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;
use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente as MovimientoPendienteAggregate;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;

/**
 * Repositorio Eloquent del agregado MovimientoPendiente.
 * Se encarga exclusivamente de persistir y reconstituir agregados sin exponer Eloquent al dominio.
 * Implementa los metodos de mapeo entre el agregado inmutable y los atributos de la base de datos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\MovimientoPendiente\Persistence\Repositories\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final class EloquentMovimientoPendienteRepository extends EloquentRepository implements MovimientoPendienteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(MovimientoPendiente::class);
    }

    /**
     * Convierte el agregado MovimientoPendiente a un array asociativo para persistencia.
     *
     * @param object $aggregate Instancia del agregado MovimientoPendiente.
     * @return array<string, mixed> Atributos mapeados para la base de datos.
     */
    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof MovimientoPendienteAggregate, 'El agregado debe ser una instancia de MovimientoPendienteAggregate');

        return [
            'id' => $aggregate->getId()->getValue(),
            'nombre' => $aggregate->getNombre(),
            'descripcion' => $aggregate->getDescripcion(),
            'tipo_movimiento_id' => $aggregate->getTipoMovimientoId(),
            'categoria_id' => $aggregate->getCategoriaId()->getValue(),
            'cuenta_id' => $aggregate->getCuentaId()->getValue(),
            'movimiento_fijo_id' => $aggregate->getMovimientoFijoId()?->getValue(),
            'monto' => $aggregate->getMonto(),
            'fecha_programada' => $aggregate->getFechaProgramada()->format('Y-m-d'),
            'dias_aviso' => $aggregate->getDiasAviso(),
            'estado' => $aggregate->getEstado()->value,
        ];
    }

    /**
     * Reconstituye el agregado MovimientoPendiente desde un registro de base de datos.
     *
     * @param Model $model Modelo Eloquent con los datos persistidos.
     * @return AggregateModelContract Agregado reconstituido.
     */
    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return MovimientoPendienteAggregate::reconstitute(
            id: new MovimientoPendienteId($model->id),
            categoria_id: new CategoriaId($model->categoria_id),
            cuenta_id: new CuentaId($model->cuenta_id),
            movimiento_fijo_id: $model->movimiento_fijo_id !== null ? new MovimientoFijoId($model->movimiento_fijo_id) : null,
            tipo_movimiento_id: (int) $model->tipo_movimiento_id,
            nombre: $model->nombre,
            monto: (float) $model->monto,
            fecha_programada: new Date(new DateTimeImmutable((string) $model->fecha_programada)),
            dias_aviso: $model->dias_aviso !== null ? (int) $model->dias_aviso : null,
            descripcion: $model->descripcion,
            estado: EstadosMovimientoPendiente::from($model->estado),
        );
    }
}
