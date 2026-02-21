<?php 

namespace App\Domains\MovimientoFijo\Services;

// Models
use App\Models\MovimientoFijo\MovimientoFijo;
//Actions
use App\Domains\MovimientoFijo\Repositories\Contracts\MovimientoFijoReadRepositoryContract;
use App\Domains\MovimientoFijo\Actions\StoreMovimientoFijoAction;
use App\Domains\MovimientoFijo\Actions\UpdateMovimientoFijoAction;
use App\Domains\MovimientoFijo\Actions\DestroyMovimientoFijoAction;
use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
use App\Domains\Categoria\Repositories\Contracts\CategoriaReadRepositoryContract;
use App\Domains\TipoMovimiento\Repositories\Contracts\TipoMovimientoReadRepositoryContract;
use App\Domains\FrecuenciaMovimiento\Actions\GetFrecuenciaMovimientoAction;
//DTOs
use App\Domains\MovimientoFijo\DTOs\MovimientoFijoFormOptionsDTO;
use App\Domains\MovimientoFijo\DTOs\UpdateMovimientoFijoDTO;
use App\Domains\MovimientoFijo\DTOs\StoreMovimientoFijoDTO;
// Resources
use App\Domains\MovimientoFijo\Resources\MovimientoFijoResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovimientoFijoService
{
    public function __construct(
        private MovimientoFijoReadRepositoryContract $movimientoFijoReadRepository,
        private StoreMovimientoFijoAction $storeMovimientoFijoAction,
        private UpdateMovimientoFijoAction $updateMovimientoFijoAction,
        private DestroyMovimientoFijoAction $destroyMovimientoFijoAction,
        private CategoriaReadRepositoryContract $categoriaReadRepository,
        private TipoMovimientoReadRepositoryContract $tipoMovimientoReadRepository,
        private GetFrecuenciaMovimientoAction $getFrecuenciaMovimientoAction,
        private CuentaReadRepositoryContract $cuentaReadRepository
    )
    {
    }

    public function store (array $data){

        $dto = StoreMovimientoFijoDTO::fromArray($data);
        return $this->storeMovimientoFijoAction->store($dto);
        
    }
    public function update(MovimientoFijo $movimientoFijo, array $data){
        $dto = UpdateMovimientoFijoDTO::fromArray($data);
        $this->updateMovimientoFijoAction->update($movimientoFijo, $dto);
    }

    public function destroy(MovimientoFijo $movimientoFijo){
        $this->destroyMovimientoFijoAction->destroy($movimientoFijo);
    }

    public function toggleActive(MovimientoFijo $movimientoFijo): bool{
        return $this->updateMovimientoFijoAction->toggleActive($movimientoFijo);
        
    }
    public function toggleRegistrarAutomatico(MovimientoFijo $movimientoFijo): bool{
        return $this->updateMovimientoFijoAction->toggleRegistrarAutomatico($movimientoFijo);
    }

    public function getAll(): AnonymousResourceCollection {
        $movimientos = $this->movimientoFijoReadRepository->getAllWithDetails();
        return MovimientoFijoResource::collection($movimientos);
    }
   public function getOptions(){
        return new MovimientoFijoFormOptionsDTO(
          $this->categoriaReadRepository->getAllWithFullDetails(),
          $this->tipoMovimientoReadRepository->getAll(),
          $this->getFrecuenciaMovimientoAction->getAll(),
            $this->cuentaReadRepository->whereAttr('active', true)->get()
        );

   }

   public function getRecordsCount(){
       return $this->movimientoFijoReadRepository->getRecordsCount();
   }
}