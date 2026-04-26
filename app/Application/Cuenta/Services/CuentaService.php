<?php

namespace App\Application\Cuenta\Services;

use App\Domains\Propietario\Contracts\Repositories\PropietarioReadRepositoryContract;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Cuenta\Services\CuentaQueryService;
use App\Domains\TipoCuenta\Contracts\Repositories\TipoCuentaReadRepositoryContract;
use App\Application\Cuenta\DTOs\CuentaFormOptionsDTO;
use App\Application\Cuenta\DTOs\StoreCuentaDTO;
use App\Application\Cuenta\DTOs\UpdateCuentaDTO;
use App\Models\Cuenta\Cuenta;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\Cuenta\CuentaResource;

/**
 * CuentaService
 * 
 * Servicio de aplicación encargado de coordinar operaciones relacionadas con Cuenta.
 * Delega responsabilidades de lectura al CuentaQueryService y de escritura al Repository.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Cuenta\Services
 * @since 1.0.0
 */
class CuentaService
{
    public function __construct(
        private CuentaQueryService $cuentaQueryService,
        private PropietarioReadRepositoryContract $propietarioReadRepository,
        private CuentaRepositoryContract $cuentaRepository,
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
        return $this->cuentaRepository->store($dto);
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
        return $this->cuentaRepository->update($cuenta, $dto);
    }

    /**
     * Elimina una cuenta
     * 
     * @param Cuenta $cuenta
     * @return bool
     */
    public function destroy(Cuenta $cuenta): bool
    {
        return $this->cuentaRepository->destroy($cuenta);
    }

    /**
     * Alterna el estado active de una cuenta
     * 
     * @param Cuenta $cuenta
     * @return bool
     */
    public function toggleActive(Cuenta $cuenta): bool
    {
        return $this->cuentaRepository->toggle($cuenta, 'active');
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
