<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Home\Queries\GenerateHomeReportQuery;
use App\Application\Reporte\Resolvers\AssemblerResolver;
use App\Http\Resources\Home\HomeResource;
class HomeApiController extends Controller
{
    public function __construct(
        private QueryBus $queryBus
    )
    {
    }
    public function index(){
         $data = $this->queryBus->ask(new GenerateHomeReportQuery());
         return HomeResource::make($data, app(AssemblerResolver::class))->response();

    }
}
