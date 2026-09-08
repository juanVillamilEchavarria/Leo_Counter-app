<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Exportacion\Persistence;

use App\Application\Exportacion\Contracts\Repositories\ExportacionRepositoryContract;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Domains\Exportacion\Enums\ExportFormat;
use App\Models\Exportacion\Exportacion;
use App\Domains\Exportacion\Aggregate\Exportacion as ExportacionAggregate;
use App\Domains\Exportacion\ValueObjects\ExportacionId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * Repositorio Eloquent para el logging de exportaciones.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final  class EloquentExportacionRepository extends EloquentRepository implements ExportacionRepositoryContract
{
    public function __construct()
    {
        parent::__construct(Exportacion::class);
    }

    /**
     * @param ExportacionAggregate $aggregate
     */
    #[Override]
    protected function mapAggregateToAttributes(object $aggregate): array
    {
        return [
            'id' => $aggregate->getId()->getValue(),
            'user_id' => $aggregate->getUserId()->getValue(),
            'table' => $aggregate->getTable()->value,
            'format' => $aggregate->getFormat()->value,
            'records_count' => $aggregate->getRecordsCount(),
            'filters' => $aggregate->getFilters() ? json_encode($aggregate->getFilters()) : null,
            'filename' => $aggregate->getFilename()
        ];
        
    }

    /**
     * @param Exportacion $model
     */
    #[Override]
    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return ExportacionAggregate::reconstitute(
            id: new ExportacionId($model->id),
            userId: new UsuarioId($model->user_id),
            table: ExportableTable::from($model->table),
            format: ExportFormat::from($model->format),
            recordsCount: $model->records_count,
            filters: $model->filters ? json_decode($model->filters, true) : null,
            filename: $model->filename
        );
    }
   
}
