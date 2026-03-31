<?php

namespace App\Domains\MovimientoPendiente\Services;

// Models
use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Models\MovimientoFijo\MovimientoFijo;
//Actions
use App\Domains\MovimientoPendiente\Repositories\Contracts\MovimientoPendienteReadRepositoryContract;
use App\Domains\MovimientoPendiente\Repositories\Contracts\MovimientoPendienteWriteRepositoryContract;
use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
use App\Domains\Categoria\Repositories\Contracts\CategoriaReadRepositoryContract;
use App\Domains\TipoMovimiento\Repositories\Contracts\TipoMovimientoReadRepositoryContract;
//Services 
use App\Domains\ArchivoMovimiento\Services\ArchivoMovimientoService;
use App\Domains\Movimiento\Services\Application\MovimientoService;
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
        private MovimientoPendienteReadRepositoryContract $movimientoPendienteReadRepository,
        private MovimientoPendienteWriteRepositoryContract $movimientoPendienteWriteRepository,
        private CuentaReadRepositoryContract $cuentaReadRepository,
        private CategoriaReadRepositoryContract $categoriaReadRepository,
        private TipoMovimientoReadRepositoryContract $tipoMovimientoReadRepository,
        private MovimientoService $movimientoService,
        private BalanceCheckerService $balanceCheckerService
    )
    {
    }


    public function store (array $data): MovimientoPendiente{
        $dto = StoreMovimientoPendienteDTO::fromArray($data);
        return $this->movimientoPendienteWriteRepository->store($dto);
    }

    public function update(MovimientoPendiente $movimientoPendiente, array $data): bool{
        $dto = UpdateMovimientoPendienteDTO::fromArray($data);
        return $this->movimientoPendienteWriteRepository->update($movimientoPendiente, $dto);
    }

    public function destroy(MovimientoPendiente $movimientoPendiente): bool{
        return $this->movimientoPendienteWriteRepository->destroy($movimientoPendiente);
    }

    public function getWithDetails(MovimientoPendiente $movimientoPendiente): ShowMovimientoPendienteResource{
        $movimiento = $this->movimientoPendienteReadRepository->getWithDetails($movimientoPendiente);
        $movimiento->enough_balance = $this->balanceCheckerService->canAfford($movimiento->cuenta_id, $movimiento->monto);
        return ShowMovimientoPendienteResource::make($movimiento);
    }

    public function getAll(): AnonymousResourceCollection {
        $movimientos = $this->movimientoPendienteReadRepository->getAll();
        $movimientos->map(function ($movimiento) {
            if($movimiento->tipo_movimiento_id === TipoMovimientoEnum::GASTO->value){
                $movimiento->enough_balance = $this->balanceCheckerService->canAfford($movimiento->cuenta_id, $movimiento->monto);
            }
            
        });
        return MovimientoPendienteResource::collection($movimientos);
    }

    public function getOptions(){
        return new MovimientoPendienteFormOptionsDTO(
            $this->categoriaReadRepository->getAllWithFullDetails(),
            $this->tipoMovimientoReadRepository->getAll(),
            $this->cuentaReadRepository->whereAttr('active', true)->get(),
            MovimientoFijo::all()
        );
    }

    public function getRecordsCount(){
        return $this->movimientoPendienteReadRepository->getAvailableRecordsCount();
    }

    public function markAsDone(MovimientoPendiente $movimientoPendiente, array $data): bool{
        $dtoMov = StoreMovimientoDTO::fromMovimientoPendiente($movimientoPendiente, $data['comprobantes'] ?? []);
        $this->movimientoService->store($dtoMov);
        $dto = MarkMovimientoPendienteDTO::fromArray(['estado'=> EstadosMovimientoPendiente::REALIZADO]);
        return $this->movimientoPendienteWriteRepository->update($movimientoPendiente, $dto);
    }
}
