<?php

namespace App\Domains\Cuenta\Services;

use App\Models\Cuenta\Cuenta;
use App\Domains\Cuenta\Contracts\Repositories\CuentaReadRepositoryContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Database\Eloquent\Collection;

/**
 * CuentaQueryService
 * 
 * Servicio de dominio encargado de delegación de responsabilidades de lectura
 * desde el Repository hacia la Application Layer (CuentaService).
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Cuenta\Services
 * @since 1.0.0
 */
class CuentaQueryService
{
    public function __construct(
        private CuentaReadRepositoryContract $repository
    )
    {
    }

    /**
     * Obtiene todas las cuentas con detalles
     * 
     * @return Collection
     */
    public function getAllWithDetails(): Collection
    {
        return $this->repository->getAllWithDetails();
    }

    /**
     * Obtiene el conteo total de cuentas
     * 
     * @return int
     */
    public function getRecordsCount(): int
    {
        return $this->repository->getRecordsCount();
    }

    /**
     * Busca una cuenta por ID
     * 
     * @param string|int $id
     * @return Cuenta|null
     */
    public function find(string|int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Busca cuentas por atributo
     * 
     * @param string $attribute
     * @param mixed $value
     * @return mixed
     */
    public function whereAttr(string $attribute, $value)
    {
        return $this->repository->whereAttr($attribute, $value);
    }
}
