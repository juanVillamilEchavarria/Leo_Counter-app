<?php

namespace App\Domains\Movimiento\Services\Domain;
// MODELS
use App\Models\Movimiento\Movimiento;
// SERVICES
use App\Domains\MovimientoFijo\Services\MovimientoFijoService;
// CONTRACTS
use App\Domains\Movimiento\Repositories\Contracts\MovimientoReadRepositoryContract;
// DTO
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use App\Shared\DTOs\Querys\TableQueryDTO;
use App\Domains\Movimiento\Resources\MovimientoResource;
use App\Domains\Movimiento\Resources\ShowMovimientoResource;
use App\Domains\Movimiento\Resources\EditMovimientoResource;
use App\Domains\Movimiento\Enums\ResourceEnum;
use App\Shared\Enums\ComparativeOperators;
use App\Domains\Movimiento\Enums\MovimientoVariants;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class MovimientoQueryService{


    protected readonly ?LengthAwarePaginator $paginator;
    public function __construct(
        private MovimientoFijoService $movimientoFijoService,
        private MovimientoReadRepositoryContract $repository
    )
    {
    }
    public function getOptions(){
      return $this->movimientoFijoService->getOptions();
    }

    public function getPaginator(){
        return $this->paginator;
    }
    public function setPaginator(LengthAwarePaginator $paginator){
        $this->paginator = $paginator;
    }

    public function getWithDetails(Movimiento $movimiento, ResourceEnum $resource = ResourceEnum::SHOW) : ShowMovimientoResource | EditMovimientoResource{
        return $resource === ResourceEnum::SHOW ?
        ShowMovimientoResource::make($this->repository->getWithDetails($movimiento)):
        EditMovimientoResource::make($movimiento->load('archivoMovimientos'));
        ;
    }

    private function getEspontaneoQuery(): array{
        return [
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
    }

    private function applyVariantQuery(MovimientoVariants $variant){
        if($variant === MovimientoVariants::ESPONTANEO){
            $wheres = $this->getEspontaneoQuery();
           return $this->repository->getAllWithDetailsWhere($wheres);
        }

        return $this->repository->getAllWithDetails();
    }

    public function getAll(MovimientoVariants $variant = MovimientoVariants::TOTAL) : AnonymousResourceCollection{
       return MovimientoResource::collection($this->applyVariantQuery($variant));
    }

    public function getAllPaginated(MovimientoVariants $variant = MovimientoVariants::TOTAL, TableQueryDTO $dto){
        $variant === MovimientoVariants::ESPONTANEO ? $wheres = $this->getEspontaneoQuery(): $wheres = [];
        $data = $this->repository->paginate($dto, $wheres);
        $this->setPaginator($data);
        return MovimientoResource::collection($data->items());
    }
    public function getRecordsCount(MovimientoVariants $variant = MovimientoVariants::TOTAL): int{
            return $variant === MovimientoVariants::ESPONTANEO ? $this->repository->getEspontaneoRecordsCount() :
            $this->repository->getRecordsCount();
    }
}