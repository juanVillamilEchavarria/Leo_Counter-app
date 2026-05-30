<?php

namespace App\Infrastructure\ArchivoMovimiento\Persistence\Repositories\Eloquent;

use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\ArchivoMovimiento\Contracts\Repositories\ArchivoMovimientoRepositoryContract;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use App\Domains\ArchivoMovimiento\Aggregates\ArchivoMovimiento as ArchivoMovimientoAggregate;
use App\Domains\ArchivoMovimiento\Enums\ArchivoMovimientoDiskEnum;
use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;
use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use Illuminate\Database\Eloquent\Model;

/**
 * Repositorio de archivos de movimiento implementado con Eloquent.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\ArchivoMovimiento\Persistence\Repositories\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final  class EloquentArchivoMovimientoRepository extends EloquentRepository implements ArchivoMovimientoRepositoryContract
{
    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof ArchivoMovimientoAggregate, 'El agregado debe ser una instancia de ArchivoMovimientoAggregate');

        return [
            'id'                => $aggregate->getId()->getValue(),
            'movimiento_id'     => $aggregate->getMovimientoId()->getValue(),
            'nombre_original'   => $aggregate->getNombreOriginal(),
            'nombre_guardado'   => $aggregate->getNombreGuardado(),
            'disk'              => $aggregate->getDisk()->value,
            'path'              => $aggregate->getPath()->toString(),
            'mime_type'         => $aggregate->getMimeType(),
            'extension'         => $aggregate->getExtension(),
            'tamano_bytes'      => $aggregate->getTamanoBytes(),
            'notas'             => $aggregate->getNotas(),
        ];
    }
    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return ArchivoMovimientoAggregate::reconstitute(
            id: new ArchivoMovimientoId($model->id),
            movimiento_id: new MovimientoId($model->movimiento_id),
            nombre_original: $model->nombre_original,
            disk: ArchivoMovimientoDiskEnum::tryFrom($model->disk) ?? ArchivoMovimientoDiskEnum::DISK,
            path: FilePath::fromString($model->path),
            mime_type: $model->mime_type,
            extension: $model->extension,
            tamano_bytes: (int) $model->tamano_bytes,
            notas: $model->notas,
        );
    }
    public function __construct()
    {
        parent::__construct(ArchivoMovimiento::class);
    }
}
