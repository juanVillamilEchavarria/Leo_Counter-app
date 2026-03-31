<?php

namespace App\Domains\Cuenta\Services\Application;

use App\Domains\Propietario\Repositories\Contracts\PropietarioReadRepositoryContract;
use App\Domains\Cuenta\Repositories\Contracts\CuentaWriteRepositoryContract;
use App\Domains\Cuenta\Services\Domain\CuentaQueryService;
use App\Domains\TipoCuenta\Repositories\Contracts\TipoCuentaReadRepositoryContract;
use App\Domains\Cuenta\DTOs\CuentaFormOptionsDTO;
use App\Domains\Cuenta\DTOs\StoreCuentaDTO;
use App\Domains\Cuenta\DTOs\UpdateCuentaDTO;
use App\Models\Cuenta\Cuenta;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Domains\Cuenta\Resources\CuentaResource;

/**
 * CuentaService
 * 
 * Servicio de aplicación encargado de coordinar operaciones relacionadas con Cuenta.
 * Delega responsabilidades de lectura al CuentaQueryService y de escritura al Repository.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Cuenta\Services\Application
 * @since 1.0.0
 */
class CuentaService
{
    public function __construct(
        private CuentaQueryService $cuentaQueryService,
        private PropietarioReadRepositoryContract $propietarioReadRepository,
        private CuentaWriteRepositoryContract $cuentaWriteRepository,
        private TipoCuentaReadRepositoryContract $tipoCuentaReadRepository
    )
    {
    }

    /**
     * Obtiene las opciones para el formulario
     * 
     * @return CuentaFormOptionsDTO
     */
    public function getOptions(): CuentaFormOptionsDTO
    {
        return new CuentaFormOptionsDTO(
            $this->propietarioReadRepository->getAll(),
            $this->tipoCuentaReadRepository->getAll()
        );
    }

    /**
     * Crea una nueva cuenta
     * 
     * @param array $data
     * @return Cuenta
     */
    public function store(array $data): Cuenta
    {
        $dto = StoreCuentaDTO::fromArray($data);
        return $this->cuentaWriteRepository->store($dto);
    }

    /**
     * Actualiza una cuenta existente
     * 
     * @param Cuenta $cuenta
     * @param array $data
     * @return bool
     */
    public function update(Cuenta $cuenta, array $data): bool
    {
        $dto = UpdateCuentaDTO::fromArray($data);
        if (!$this->canUpdateSaldoInicial($cuenta)) {
            $dto->setExcept(['saldo_actual']);
        }
        return $this->cuentaWriteRepository->update($cuenta, $dto);
    }

    /**
     * Elimina una cuenta
     * 
     * @param Cuenta $cuenta
     * @return bool
     */
    public function destroy(Cuenta $cuenta): bool
    {
        return $this->cuentaWriteRepository->destroy($cuenta);
    }

    /**
     * Alterna el estado active de una cuenta
     * 
     * @param Cuenta $cuenta
     * @return bool
     */
    public function toggleActive(Cuenta $cuenta): bool
    {
        return $this->cuentaWriteRepository->toggle($cuenta, 'active');
    }

    /**
     * Obtiene todas las cuentas disponibles con detalles
     * Delega al QueryService
     * 
     * @return AnonymousResourceCollection
     */
    public function getAllAvailableWhitDetails(): AnonymousResourceCollection
    {
        $cuentas = $this->cuentaQueryService->getAllWithDetails();
        return CuentaResource::collection($cuentas);
    }

    /**
     * Obtiene el conteo total de cuentas
     * Delega al QueryService
     * 
     * @return int
     */
    public function getRecordsCount(): int
    {
        return $this->cuentaQueryService->getRecordsCount();
    }

    /**
     * Verifica si se puede actualizar el saldo inicial
     * 
     * @param Cuenta $cuenta
     * @return bool
     */
    public function canUpdateSaldoInicial(Cuenta $cuenta): bool
    {
        return !$cuenta->movimientos()->exists();
    }
}
