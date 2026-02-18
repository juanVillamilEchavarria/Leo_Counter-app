<?php

namespace App\Domains\MovimientoPendiente\Services;

// Models
use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Models\MovimientoFijo\MovimientoFijo;
//Actions
use App\Domains\MovimientoPendiente\Actions\GetMovimientoPendienteAction;
use App\Domains\MovimientoPendiente\Actions\StoreMovimientoPendienteAction;
use App\Domains\MovimientoPendiente\Actions\UpdateMovimientoPendienteAction;
use App\Domains\MovimientoPendiente\Actions\DestroyMovimientoPendienteAction;
use App\Domains\Cuenta\Actions\GetCuentaAction;
use App\Domains\Categoria\Actions\GetCategoriaAction;
use App\Domains\Movimiento\Actions\StoreMovimientoAction;
use App\Domains\TipoMovimiento\Actions\GetTipoMovimientoAction;
//Services 
use App\Domains\ArchivoMovimiento\Services\ArchivoMovimientoService;
use App\Domains\Movimiento\Service\Application\MovimientoService;
use App\Shared\Services\Financial\BalanceCheckerService;
//DTOs
use App\Domains\MovimientoPendiente\DTOs\MovimientoPendienteFormOptionsDTO;
use App\Domains\MovimientoPendiente\DTOs\UpdateMovimientoPendienteDTO;
use App\Domains\MovimientoPendiente\DTOs\StoreMovimientoPendienteDTO;
use App\Domains\MovimientoPendiente\DTOs\MarkMovimientoPendienteDTO;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Domains\ArchivoMovimiento\DTOs\ArchivoMovimientoTransferDTO;
// Resources
use App\Domains\MovimientoPendiente\Resources\MovimientoPendienteResource;
use App\Domains\MovimientoPendiente\Resources\ShowMovimientoPendienteResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

//ENUMS
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

class MovimientoPendienteService
{
    public function __construct(
        private GetMovimientoPendienteAction $getMovimientoPendienteAction,
        private StoreMovimientoPendienteAction $storeMovimientoPendienteAction,
        private UpdateMovimientoPendienteAction $updateMovimientoPendienteAction,
        private DestroyMovimientoPendienteAction $destroyMovimientoPendienteAction,
        private GetCuentaAction $getCuentaAction,
        private GetCategoriaAction $getCategoriaAction,
        private GetTipoMovimientoAction $getTipoMovimientoAction,
        private MovimientoService $movimientoService,
        private BalanceCheckerService $balanceCheckerService
    )
    {
    }


    public function store (array $data): MovimientoPendiente{
        $dto = StoreMovimientoPendienteDTO::fromArray($data);
        return $this->storeMovimientoPendienteAction->store($dto);
    }

    public function update(MovimientoPendiente $movimientoPendiente, array $data): bool{
        $dto = UpdateMovimientoPendienteDTO::fromArray($data);
        return $this->updateMovimientoPendienteAction->update($movimientoPendiente, $dto);
    }

    public function destroy(MovimientoPendiente $movimientoPendiente): bool{
        return $this->destroyMovimientoPendienteAction->destroy($movimientoPendiente);
    }

    public function getWithDetails(MovimientoPendiente $movimientoPendiente): ShowMovimientoPendienteResource{
        $movimiento = $this->getMovimientoPendienteAction->getWithDetails($movimientoPendiente);
        $movimiento->enough_balance = $this->balanceCheckerService->canAfford($movimiento->cuenta_id, $movimiento->monto);
        return ShowMovimientoPendienteResource::make($movimiento);
    }

    public function getAll(): AnonymousResourceCollection {
        $movimientos = $this->getMovimientoPendienteAction->getAll();
        $movimientos->map(function ($movimiento) {
            if($movimiento->tipo_movimiento_id === TipoMovimientoEnum::GASTO->value){
                $movimiento->enough_balance = $this->balanceCheckerService->canAfford($movimiento->cuenta_id, $movimiento->monto);
            }
            
        });
        return MovimientoPendienteResource::collection($movimientos);
    }

    public function getOptions(){
        return new MovimientoPendienteFormOptionsDTO(
            $this->getCategoriaAction->getAll(),
            $this->getTipoMovimientoAction->getAll(),
            $this->getCuentaAction->where('active', true)->get(),
            MovimientoFijo::all()
        );
    }

    public function getRecordsCount(){
        return $this->getMovimientoPendienteAction->getAvalaibleRecordsCount();
    }

    public function markAsDone(MovimientoPendiente $movimientoPendiente, array $data): bool{
        $dtoMov = StoreMovimientoDTO::fromMovimientoPendiente($movimientoPendiente, $data['comprobantes'] ?? []);
        $this->movimientoService->store($dtoMov);
        $dto = MarkMovimientoPendienteDTO::fromArray(['estado'=> EstadosMovimientoPendiente::REALIZADO]);
        return $this->updateMovimientoPendienteAction->update($movimientoPendiente, $dto);
    }
}
