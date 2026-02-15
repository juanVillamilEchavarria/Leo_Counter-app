<?php

namespace App\Domains\Movimiento\Service\Application;


// Actions
use App\Domains\Cuenta\Actions\GetCuentaAction;
// Services 
use App\Shared\Services\BalanceCheckerService;
use App\Domains\Movimiento\Service\Domain\MovimientoFinancialService;
use App\Domains\Movimiento\Service\Domain\MovimientoQueryService;
// Strategies
use App\Domains\Movimiento\Strategies\Application\CuentaResolverStrategy;
// DTOs y Resources
use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Domains\Movimiento\DTOs\UpdateMovimientoDTO;
use App\Domains\Movimiento\Resources\ShowMovimientoResource;
use App\Domains\Movimiento\Resources\EditMovimientoResource;
// Models
use App\Models\Movimiento\Movimiento;
// Exceptions
use App\Domains\Movimiento\Exceptions\CannotStoreMovimientoException;
use App\Models\Cuenta\Cuenta;
use App\Shared\Exceptions\InsufficientBalanceException;
// Enums y types
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Domains\Movimiento\Enums\MovimientoVariants;
use App\Domains\Movimiento\Enums\ResourceEnum;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

class MovimientoService{
    public function __construct(
        private GetCuentaAction $getCuentaAction,
        private MovimientoQueryService $movimientoQueryService,
        private MovimientoFinancialService $movimientoFinancialService,
        private BalanceCheckerService $balanceCheckerService,
        private CuentaResolverStrategy $cuentaResolverStrategy,
    )
    {
    }
    // METODOS PRIVADOS PARA LA LOGICA PROPIA DEL SERVICE
    private function resolveCuenta(StoreMovimientoDTO | UpdateMovimientoDTO $dto){
        return $this->cuentaResolverStrategy->resolve($dto->tipo_movimiento_id, $dto->cuenta_id, $dto->monto);
        
    }
    // METODOS PUBLICOS
    public function store(StoreMovimientoDTO | array $data): Movimiento{
        if(is_array($data)) $data = StoreMovimientoDTO::fromArray($data);
        $cuenta = $this->resolveCuenta($data);
        return $this->movimientoFinancialService->executeMovimientoTransaction($data, $cuenta, null);
    }
    public function update(Movimiento $movimiento, array $data){
        $dto = UpdateMovimientoDTO::fromArray($data);
        $cuenta = $this->resolveCuenta($dto);
        return $this->movimientoFinancialService->executeMovimientoTransaction($dto, $cuenta, $movimiento);
        
    }


    public function getOptions(){
        return $this->movimientoQueryService->getOptions();
 
    }

    public function getWithDetails(Movimiento $movimiento, ResourceEnum $resource = ResourceEnum::SHOW) : ShowMovimientoResource | EditMovimientoResource{

        return $this->movimientoQueryService->getWithDetails($movimiento, $resource);
    }

    public function getAll(MovimientoVariants $variant = MovimientoVariants::TOTAL) : AnonymousResourceCollection{

        return $this->movimientoQueryService->getAll($variant);

    }
    public function getRecordsCount(MovimientoVariants $variant = MovimientoVariants::TOTAL): int{

        return $this->movimientoQueryService->getRecordsCount($variant);
    }
}