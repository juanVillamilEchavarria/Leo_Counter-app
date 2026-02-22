<?php

namespace App\Domains\Movimiento\Service\Application;


// Actions
use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
// Services 
use App\Domains\Auth\Services\Application\AuthService;
use App\Domains\Movimiento\Service\Domain\MovimientoFinancialService;
use App\Domains\Movimiento\Service\Domain\MovimientoQueryService;
// Strategies
use App\Domains\Movimiento\Strategies\Application\CuentaResolverStrategy;
// DTOs y Resources
use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Domains\Movimiento\DTOs\UpdateMovimientoDTO;
use App\Domains\Movimiento\DTOs\DestroyMovimientoDTO;
use App\Shared\DTOs\Querys\TableQueryDTO;
use App\Domains\Movimiento\Resources\ShowMovimientoResource;
use App\Domains\Movimiento\Resources\EditMovimientoResource;
// Models
use App\Models\Movimiento\Movimiento;
use App\Models\Cuenta\Cuenta;
// Exceptions
use App\Domains\Cuenta\Exceptions\CannotFindCuentaException;
use App\Domains\Movimiento\Exceptions\CannotDeleteMovimientoException;
// Contracts
use App\Domains\Movimiento\Repositories\Contracts\MovimientoWriteRepositoryContract;
// Enums y types
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Domains\Movimiento\Enums\MovimientoVariants;
use App\Domains\Movimiento\Enums\ResourceEnum;


class MovimientoService{
    public function __construct(
        private MovimientoQueryService $movimientoQueryService,
        private MovimientoFinancialService $movimientoFinancialService,
        private AuthService $authService,
        private CuentaResolverStrategy $cuentaResolverStrategy,
        private CuentaReadRepositoryContract $cuentaReadRepository
    )
    {
    }
    // METODOS PRIVADOS PARA LA LOGICA PROPIA DEL SERVICE
    private function resolveCuenta(StoreMovimientoDTO | UpdateMovimientoDTO | DestroyMovimientoDTO $dto, ?Movimiento $movimiento = null): Cuenta{
        return $this->cuentaResolverStrategy->resolve($dto->tipo_movimiento_id, $dto->cuenta_id, $dto->monto, $movimiento?->id);
        
    }
    // METODOS PUBLICOS
    public function store(StoreMovimientoDTO | array $data): Movimiento{
        if(is_array($data)) $data = StoreMovimientoDTO::fromArray($data);
        $cuenta = $this->resolveCuenta($data);
        return $this->movimientoFinancialService->executeMovimientoTransaction($data, $cuenta, null);
    }
    public function update(Movimiento $movimiento, array $data){
        $dto = UpdateMovimientoDTO::fromArray($data);
        $cuenta = $this->resolveCuenta($dto, $movimiento);
        return $this->movimientoFinancialService->executeMovimientoTransaction($dto, $cuenta, $movimiento);
        
    }

    public function destroy(Movimiento $movimiento, array $data){
        $dto = DestroyMovimientoDTO::fromArray($data);
        if(!$this->authService->verifyPassword($dto->password)){
            throw new CannotDeleteMovimientoException('No se puede eliminar el movimiento, la contraseña proporcionada es incorrecta');
        }
        try {
            $cuenta = $this->cuentaReadRepository->whereAttr('id', $movimiento->cuenta_id)->firstOrFail();
        } catch (\Throwable $th) {
            throw new CannotFindCuentaException('No se encontro la cuenta asociada al movimiento, error: ' . $th->getMessage());
        }
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

    public function getAllPaginated(MovimientoVariants $variant = MovimientoVariants::TOTAL, array $data){

        $dto = TableQueryDTO::fromArray($data);
        return $this->movimientoQueryService->getAllPaginated($variant, $dto);
    }

    public function getPaginatorMetaData(){
        $paginator= $this->movimientoQueryService->getPaginator();
        return [
            'currentPage'=> $paginator->currentPage(),
            'perPage'=> $paginator->perPage(),
            'lastPage'=> $paginator->lastPage(),
            'total' => $paginator->total(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem()
        ];
    }

    public function getRecordsCount(MovimientoVariants $variant = MovimientoVariants::TOTAL): int{

        return $this->movimientoQueryService->getRecordsCount($variant);
    }
}