<?php

namespace App\Domains\Movimiento\Services;
// MODELS
use App\Models\Movimiento\Movimiento;
use App\Application\MovimientoFijo\DTOs\MovimientoFijoFormOptionsDTO;
// CONTRACTS
use App\Domains\Movimiento\Contracts\Repositories\MovimientoReadRepositoryContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCategoriaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCuentaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListFrecuenciaMovimientoForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListTipoMovimientoForFormContract;
// DTO
use App\Shared\Domain\ValueObjects\WhereFilterQueryDTO;
use App\Shared\Domain\ValueObjects\TableQueryDTO;
use App\Http\Resources\Movimiento\MovimientoResource;
use App\Http\Resources\Movimiento\ShowMovimientoResource;
use App\Http\Resources\Movimiento\EditMovimientoResource;
use App\Domains\Movimiento\Enums\ResourceEnum;
use App\Shared\Enums\ComparativeOperators;
use App\Domains\Movimiento\Enums\MovimientoVariants;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class MovimientoQueryService{


    protected readonly ?LengthAwarePaginator $paginator;
    public function __construct(
        private MovimientoReadRepositoryContract $repository,
        private ListCategoriaForFormContract $categoriaForForm,
        private ListCuentaForFormContract $cuentaForForm,
        private ListTipoMovimientoForFormContract $tipoMovimientoForForm,
        private ListFrecuenciaMovimientoForFormContract $frecuenciaMovimientoForForm,
    )
    {
    }
    public function getOptions(): MovimientoFijoFormOptionsDTO{
      return new MovimientoFijoFormOptionsDTO(
          categorias: $this->categoriaForForm->execute(),
          tipos_movimientos: $this->tipoMovimientoForForm->execute(),
          frecuencias_movimientos: $this->frecuenciaMovimientoForForm->execute(),
          cuentas: $this->cuentaForForm->execute(),
      );
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
