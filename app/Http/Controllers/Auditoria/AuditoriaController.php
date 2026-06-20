<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Controllers\Auditoria;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Auditoria\Queries\GetAuditoriaRecordsCountQuery;


/**
 * Controlador para páginas de Auditoría (solo render Inertia para el listado).
 */
final class AuditoriaController extends Controller
{
    public function __construct(
        private QueryBus $queryBus
    )
    {
    }
    public function index()
    {
        $records= $this->queryBus->ask(new GetAuditoriaRecordsCountQuery());
        return Inertia::render('Auditorias/Index',[
            'NoRegistros' => $records,
            'title'=> 'Auditorias'
        ]);
    }
}
