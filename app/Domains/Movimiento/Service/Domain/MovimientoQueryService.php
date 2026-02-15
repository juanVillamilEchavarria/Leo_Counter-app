<?php

namespace App\Domains\Movimiento\Service\Domain;
use App\Models\Movimiento\Movimiento;
use App\Domains\MovimientoFijo\Services\MovimientoFijoService;
use App\Domains\Movimiento\Actions\GetMovimientoAction;
use App\Shared\DTOs\WhereFilterQueryDTO;
use App\Domains\Movimiento\Resources\MovimientoResource;
use App\Domains\Movimiento\Resources\ShowMovimientoResource;
use App\Domains\Movimiento\Resources\EditMovimientoResource;
use App\Domains\Movimiento\Enums\ResourceEnum;
use App\Shared\Enums\ComparativeOperators;
use App\Domains\Movimiento\Enums\MovimientoVariants;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovimientoQueryService{

    public function __construct(
        private MovimientoFijoService $movimientoFijoService,
        private GetMovimientoAction $getMovimientoAction
    )
    {
    }
    public function getOptions(){
      return $this->movimientoFijoService->getOptions();
    }

    public function getWithDetails(Movimiento $movimiento, ResourceEnum $resource = ResourceEnum::SHOW) : ShowMovimientoResource | EditMovimientoResource{
        return $resource === ResourceEnum::SHOW ?
        ShowMovimientoResource::make($this->getMovimientoAction->getWithDetails($movimiento)):
        EditMovimientoResource::make($movimiento->load('archivoMovimientos'));
        ;
    }

    public function getAll(MovimientoVariants $variant = MovimientoVariants::TOTAL) : AnonymousResourceCollection{
        if($variant === MovimientoVariants::ESPONTANEO){
            $wheres = [
                new WhereFilterQueryDTO(
                    'fecha',
                    ComparativeOperators::EQUALS,
                    Carbon::now()->format('Y-m-d')
                ),
                new WhereFilterQueryDTO(
                    'movimiento_pendiente_id',
                    ComparativeOperators::EQUALS,
                    null
                )
            ];
            return MovimientoResource::collection($this->getMovimientoAction->getAllWithDetailsWhere($wheres));
        }
         return MovimientoResource::collection($this->getMovimientoAction->getAllWithDetails());
    }
    public function getRecordsCount(MovimientoVariants $variant = MovimientoVariants::TOTAL): int{
            return $variant === MovimientoVariants::ESPONTANEO ? $this->getMovimientoAction->getEspontaneoRecordsCount() :
            $this->getMovimientoAction->getRecordsCount();
    }
}