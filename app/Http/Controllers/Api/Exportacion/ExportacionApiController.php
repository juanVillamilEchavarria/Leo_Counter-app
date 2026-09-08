<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Http\Controllers\Api\Exportacion;

use App\Application\Exportacion\Commands\ExportDataCommand;
use App\Application\Exportacion\Mappers\ExportacionForTableMapper;
use App\Application\Exportacion\Mappers\ExportTableQueryMapper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exportacion\ExportDataRequest;
use App\Http\Requests\Shared\TableQueryRequest;
use App\Http\Resources\Exportacion\ExportacionResource;
use App\Http\Resources\Shared\PaginationMetaResource;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Shared\Application\Contracts\Bus\QueryBus;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Controller API del módulo Exportación.
 * Responsable tanto de la generación del archivo (streaming) como del
 * listado paginado del historial de exportaciones.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final class ExportacionApiController extends Controller
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus,
        private ExportacionForTableMapper $mapper,
    ) {}

    public function __invoke(ExportDataRequest $request): StreamedResponse
    {
        set_time_limit(300);
        $tableQuery = ($request->validated('filters')!== null && $request->validated('filters')!== []) ? (new ExportTableQueryMapper)->mapFromArray($request->validated('filters')) : null;

        $command = new ExportDataCommand(
            userId: (string) Auth::id(),
            table: $request->getTable(),
            format: $request->getExportFormat(),
            filters: $tableQuery,
            visibleIds: $request->validated('visibleIds'),
            onlyCurrentPage: $request->boolean('only_current_page', false),
            filename: $request->validated('filename'),
        );

        $result = $this->commandBus->dispatch($command);

        return response()->streamDownload(
            $result->streamCallback,
            $result->filename,
            [
                'Content-Type' => $result->getMimeType(),
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

    public function totalPaginated(TableQueryRequest $request)
    {
        $query = $this->mapper->map($request);
        $result = $this->queryBus->ask($query);

        return response()->json([
            'data' => ExportacionResource::collection($result->items),
            'meta' => PaginationMetaResource::make($result),
        ]);
    }
}
