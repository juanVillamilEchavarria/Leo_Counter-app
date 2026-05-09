<?php

// ┌──────────────────────────────────────────────────────────────────────────┐
// │ ARCHIVO OBSOLETO — Comentado completamente tras el refactor CQRS/DDD   │
// │ del módulo MovimientoPendiente.                                         │
// │                                                                         │
// │ La lógica de este servicio ha sido reemplazada por:                      │
// │  - Comandos: StoreMovimientoPendienteCommand, UpdateMovimientoPendienteCommand, │
// │              DestroyMovimientoPendienteCommand                          │
// │  - Queries:  ListAllMovimientoPendienteQuery, GetMovimientoPendienteForEditQuery, │
// │              GetMovimientoPendienteRecordsCountQuery,                   │
// │              ListMovimientoPendienteFormOptionsQuery                    │
// │  - Handlers correspondientes en Commands/Handlers/ y Queries/Handlers/ │
// │                                                                         │
// │ NO ELIMINAR hasta que se confirme la estabilidad del refactor.          │
// └──────────────────────────────────────────────────────────────────────────┘

// namespace App\Application\MovimientoPendiente\Services;
//
// // Models
// use App\Models\MovimientoPendiente\MovimientoPendiente;
// use App\Models\MovimientoFijo\MovimientoFijo;
// //Actions
// use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteReadRepositoryContract;
// use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
// use App\Domains\Cuenta\Contracts\Repositories\CuentaReadRepositoryContract;
// use App\Domains\Categoria\Contracts\Repositories\CategoriaReadRepositoryContract;
// use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoReadRepositoryContract;
// //Services
// use App\Application\ArchivoMovimiento\Services\ArchivoMovimientoService;
// use App\Application\Movimiento\Services\MovimientoService;
// use App\Shared\Services\Financial\BalanceCheckerService;
// //DTOs
// use App\Application\MovimientoPendiente\DTOs\MovimientoPendienteFormOptionsDTO;
// use App\Application\MovimientoPendiente\DTOs\UpdateMovimientoPendienteDTO;
// use App\Application\MovimientoPendiente\DTOs\StoreMovimientoPendienteDTO;
// use App\Application\MovimientoPendiente\DTOs\MarkMovimientoPendienteDTO;
// use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
// use App\Application\Movimiento\DTOs\StoreMovimientoDTO;
// use App\Application\ArchivoMovimiento\DTOs\ArchivoMovimientoTransferDTO;
// // Resources
// use App\Http\Resources\MovimientoPendiente\MovimientoPendienteResource;
// use App\Http\Resources\MovimientoPendiente\ShowMovimientoPendienteResource;
// use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
//
// //ENUMS
// use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
//
// class MovimientoPendienteService
// {
//     public function __construct(
//         private MovimientoPendienteReadRepositoryContract $movimientoPendienteReadRepository,
//         private MovimientoPendienteRepositoryContract $movimientoPendienteRepository,
//         private CuentaReadRepositoryContract $cuentaReadRepository,
//         private CategoriaReadRepositoryContract $categoriaReadRepository,
//         private TipoMovimientoReadRepositoryContract $tipoMovimientoReadRepository,
//         private MovimientoService $movimientoService,
//         private BalanceCheckerService $balanceCheckerService
//     )
//     {
//     }
//
//
//     public function store (array $data): MovimientoPendiente{
//         $dto = StoreMovimientoPendienteDTO::fromArray($data);
//         return $this->movimientoPendienteRepository->store($dto);
//     }
//
//     public function update(MovimientoPendiente $movimientoPendiente, array $data): bool{
//         $dto = UpdateMovimientoPendienteDTO::fromArray($data);
//         return $this->movimientoPendienteRepository->update($movimientoPendiente, $dto);
//     }
//
//     public function destroy(MovimientoPendiente $movimientoPendiente): bool{
//         return $this->movimientoPendienteRepository->destroy($movimientoPendiente);
//     }
//
//     public function getWithDetails(MovimientoPendiente $movimientoPendiente): ShowMovimientoPendienteResource{
//         $movimiento = $this->movimientoPendienteReadRepository->getWithDetails($movimientoPendiente);
//         $movimiento->enough_balance = $this->balanceCheckerService->canAfford($movimiento->cuenta_id, $movimiento->monto);
//         return ShowMovimientoPendienteResource::make($movimiento);
//     }
//
//     public function getAll(): AnonymousResourceCollection {
//         $movimientos = $this->movimientoPendienteReadRepository->getAll();
//         $movimientos->map(function ($movimiento) {
//             if($movimiento->tipo_movimiento_id === TipoMovimientoEnum::GASTO->value){
//                 $movimiento->enough_balance = $this->balanceCheckerService->canAfford($movimiento->cuenta_id, $movimiento->monto);
//             }
//
//         });
//         return MovimientoPendienteResource::collection($movimientos);
//     }
//
//     public function getOptions(){
//         return new MovimientoPendienteFormOptionsDTO(
//             $this->categoriaReadRepository->getAllWithFullDetails(),
//             $this->tipoMovimientoReadRepository->getAll(),
//             $this->cuentaReadRepository->whereAttr('active', true)->get(),
//             MovimientoFijo::all()
//         );
//     }
//
//     public function getRecordsCount(){
//         return $this->movimientoPendienteReadRepository->getAvailableRecordsCount();
//     }
//
//     public function markAsDone(MovimientoPendiente $movimientoPendiente, array $data): bool{
//         $dtoMov = StoreMovimientoDTO::fromMovimientoPendiente($movimientoPendiente, $data['comprobantes'] ?? []);
//         $this->movimientoService->store($dtoMov);
//         $dto = MarkMovimientoPendienteDTO::fromArray(['estado'=> EstadosMovimientoPendiente::REALIZADO]);
//         return $this->movimientoPendienteRepository->update($movimientoPendiente, $dto);
//     }
// }
