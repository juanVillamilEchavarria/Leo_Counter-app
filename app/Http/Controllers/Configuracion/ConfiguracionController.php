<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Controllers\Configuracion;

use App\Application\Notificacion\Queries\ListAllCanalesNotificacionQuery;
use App\Application\Notificacion\Queries\ListAllSuscriptoresWithDetailsQuery;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Notificacion\Queries\ListSuscriptoresFormOptionsQuery;

class ConfiguracionController extends Controller
{
    public function __construct(
        private QueryBus $queryBus
    )
    {
    }


    public function index(){
        $suscriptores = $this->queryBus->ask(new ListAllSuscriptoresWithDetailsQuery());
        $canales = $this->queryBus->ask(new ListAllCanalesNotificacionQuery());
        return Inertia::render('Configuracion/Index',[
            'title' => 'Configuración',
            'suscriptores' => $suscriptores,
            'canales' => $canales
        ]);
    }
}
