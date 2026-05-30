<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Controllers\Presupuesto;

use App\Application\Presupuesto\Queries\GetHistoricPresupuestosRecordsCountQuery;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Shared\Application\Contracts\Bus\QueryBus;
class PresupuestoHistoricoController extends Controller
{
    public function __construct(
        private QueryBus $queryBus
    ) {}

    public function index()
    {
        $totalRecords= $this->queryBus->ask(new GetHistoricPresupuestosRecordsCountQuery());

        return Inertia::render('Presupuestos/Historicos/Index', [
            'title' => 'Presupuestos Historicos',
            'NoRegistros' => $totalRecords
        ]);
    }
}
