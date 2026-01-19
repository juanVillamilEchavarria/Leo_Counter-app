<?php 

namespace App\Domains\MovimientoFijo\Services;

use App\Models\MovimientoFijo\MovimientoFijo;
use App\Domains\MovimientoFijo\Actions\GetMovimientoFijoAction;
use App\Domains\MovimientoFijo\Actions\StoreMovimientoFijoAction;
use App\Domains\MovimientoFijo\Actions\UpdateMovimientoFijoAction;
use App\Domains\Cuenta\Actions\GetCuentaAction;
use App\Domains\Categoria\Actions\GetCategoriaAction;
use App\Domains\TipoMovimiento\Actions\GetTipoMovimientoAction;
use App\Domains\FrecuenciaMovimiento\Actions\GetFrecuenciaMovimientoAction;
use App\Domains\MovimientoFijo\DTOs\MovimientoFijoFormOptionsDTO;
use App\Domains\MovimientoFijo\DTOs\StoreMovimientoFijoDTO;

class MovimientoFijoService
{
    public function __construct(
        private GetMovimientoFijoAction $getMovimientoFijoAction,
        private StoreMovimientoFijoAction $storeMovimientoFijoAction,
        private UpdateMovimientoFijoAction $updateMovimientoFijoAction,
        private GetCategoriaAction $getCategoriaAction,
        private GetTipoMovimientoAction $getTipoMovimientoAction,
        private GetFrecuenciaMovimientoAction $getFrecuenciaMovimientoAction,
        private GetCuentaAction $getCuentaAction
    )
    {
    }

    public function store (array $data){

        $dto = new StoreMovimientoFijoDTO(
            cuenta_id: $data['cuenta_id'],
            categoria_id: $data['categoria_id'],
            tipo_movimiento_id: $data['tipo_movimiento_id'],
            frecuencia_movimiento_id: $data['frecuencia_movimiento_id'],
            nombre: $data['nombre'],
            descripcion: $data['descripcion'],
            monto: $data['monto'],
            fecha_proximo: $data['fecha_proximo'],
            url_pago: $data['url_pago'] ?? '',
        );
        return $this->storeMovimientoFijoAction->store($dto);
        
    }

    public function toggleActive(MovimientoFijo $movimientoFijo): bool{
        return $this->updateMovimientoFijoAction->toggleActive($movimientoFijo);
        
    }
    public function toggleRegistrarAutomatico(MovimientoFijo $movimientoFijo): bool{
        return $this->updateMovimientoFijoAction->toggleRegistrarAutomatico($movimientoFijo);
    }

    public function getAll(){
        return $this->getMovimientoFijoAction->getAll();
    }
   public function getOptions(){
        return new MovimientoFijoFormOptionsDTO(
            $this->getCategoriaAction->getAllWithFullDetails(),
            $this->getTipoMovimientoAction->getAll(),
            $this->getFrecuenciaMovimientoAction->getAll(),
            $this->getCuentaAction->allAvailable()->get()
        );

   }
}