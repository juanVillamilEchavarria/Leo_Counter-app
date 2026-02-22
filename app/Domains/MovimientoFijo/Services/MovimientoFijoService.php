<?php 

namespace App\Domains\MovimientoFijo\Services;

// Models
use App\Models\MovimientoFijo\MovimientoFijo;
//Actions
use App\Domains\MovimientoFijo\Repositories\Contracts\MovimientoFijoReadRepositoryContract;
use App\Domains\MovimientoFijo\Repositories\Contracts\MovimientoFijoWriteRepositoryContract;
use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
use App\Domains\Categoria\Repositories\Contracts\CategoriaReadRepositoryContract;
use App\Domains\TipoMovimiento\Repositories\Contracts\TipoMovimientoReadRepositoryContract;
use App\Domains\FrecuenciaMovimiento\Repositories\Contracts\FrecuenciaMovimientoReadRepositoryContract;
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
        private MovimientoFijoWriteRepositoryContract $movimientoFijoWriteRepository,
        private CategoriaReadRepositoryContract $categoriaReadRepository,
        private TipoMovimientoReadRepositoryContract $tipoMovimientoReadRepository,
        private FrecuenciaMovimientoReadRepositoryContract $frecuenciaMovimientoReadRepository,
        private CuentaReadRepositoryContract $cuentaReadRepository
    )
    {
    }

    public function store (array $data){

        $dto = StoreMovimientoFijoDTO::fromArray($data);
        return $this->movimientoFijoWriteRepository->store($dto);
        
    }
    public function update(MovimientoFijo $movimientoFijo, array $data){
        $dto = UpdateMovimientoFijoDTO::fromArray($data);
        $this->movimientoFijoWriteRepository->update($movimientoFijo, $dto);
    }

    public function destroy(MovimientoFijo $movimientoFijo){
        $this->movimientoFijoWriteRepository->destroy($movimientoFijo);
    }

    public function toggleActive(MovimientoFijo $movimientoFijo): bool{
        return $this->movimientoFijoWriteRepository->toggleActive($movimientoFijo);
        
    }
    public function toggleRegistrarAutomatico(MovimientoFijo $movimientoFijo): bool{
        return $this->movimientoFijoWriteRepository->toggleRegistrarAutomaticamente($movimientoFijo);
    }

    public function getAll(): AnonymousResourceCollection {
        $movimientos = $this->movimientoFijoReadRepository->getAllWithDetails();
        return MovimientoFijoResource::collection($movimientos);
    }
   public function getOptions(){
        return new MovimientoFijoFormOptionsDTO(
          $this->categoriaReadRepository->getAllWithFullDetails(),
          $this->tipoMovimientoReadRepository->getAll(),
          $this->frecuenciaMovimientoReadRepository->getAll(),
            $this->cuentaReadRepository->whereAttr('active', true)->get()
        );

   }

   public function getRecordsCount(){
       return $this->movimientoFijoReadRepository->getRecordsCount();
   }
}