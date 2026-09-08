<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Http\Controllers\Exportacion;

use App\Application\Exportacion\Queries\GetExportacionesRecordsCountQuery;
use App\Http\Controllers\Controller;
use App\Shared\Application\Contracts\Bus\QueryBus;
use Inertia\Inertia;

/**
 * Controller web (Inertia) del historial de exportaciones.
 * Solo administradores acceden; no existe caso de uso `show`.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final class ExportacionController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
    ) {}

    /**
     * @return array<string, mixed>
     */
    protected function props(): array
    {
        return [
            'title' => 'Historial de Exportaciones',
            'NoRegistros' => $this->queryBus->ask(new GetExportacionesRecordsCountQuery),
        ];
    }

    public function index()
    {
        return Inertia::render('Exportaciones/Index', $this->props());
    }
}
