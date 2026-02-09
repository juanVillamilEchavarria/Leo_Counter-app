<?php 

namespace App\Domains\MovimientoFijo\Services;

// Models
use App\Models\MovimientoFijo\MovimientoFijo;
//Actions
use App\Domains\MovimientoFijo\Actions\GetMovimientoFijoAction;
use App\Domains\MovimientoFijo\Actions\StoreMovimientoFijoAction;
use App\Domains\MovimientoFijo\Actions\UpdateMovimientoFijoAction;
use App\Domains\MovimientoFijo\Actions\DestroyMovimientoFijoAction;
use App\Domains\Cuenta\Actions\GetCuentaAction;
use App\Domains\Categoria\Actions\GetCategoriaAction;
use App\Domains\TipoMovimiento\Actions\GetTipoMovimientoAction;
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
        private GetMovimientoFijoAction $getMovimientoFijoAction,
        private StoreMovimientoFijoAction $storeMovimientoFijoAction,
        private UpdateMovimientoFijoAction $updateMovimientoFijoAction,
        private DestroyMovimientoFijoAction $destroyMovimientoFijoAction,
        private GetCategoriaAction $getCategoriaAction,
        private GetTipoMovimientoAction $getTipoMovimientoAction,
        private GetFrecuenciaMovimientoAction $getFrecuenciaMovimientoAction,
        private GetCuentaAction $getCuentaAction
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
        $movimientos = $this->getMovimientoFijoAction->getAll();
        return MovimientoFijoResource::collection($movimientos);
    }
   public function getOptions(){
        return new MovimientoFijoFormOptionsDTO(
            $this->getCategoriaAction->getAll(),
            $this->getTipoMovimientoAction->getAll(),
            $this->getFrecuenciaMovimientoAction->getAll(),
            $this->getCuentaAction->where('active', true)->get()
        );

   }

   public function getRecordsCount(){
        return $this->getMovimientoFijoAction->getRecordsCount();
   }
}