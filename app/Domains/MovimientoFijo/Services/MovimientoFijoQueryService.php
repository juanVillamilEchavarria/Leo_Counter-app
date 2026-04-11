<?php

namespace App\Domains\MovimientoFijo\Services;

// MODELS
use App\Models\MovimientoFijo\MovimientoFijo;
// CONTRACTS
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoReadRepositoryContract;
// DTO
use App\Shared\DTOs\Querys\TableQueryDTO;
// Resources
use App\Http\Resources\MovimientoFijo\MovimientoFijoResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Database\Eloquent\Collection;

/**
 * MovimientoFijoQueryService
 * 
 * Servicio de dominio encargado de delegación de responsabilidades de lectura
 * desde el Repository hacia la Application Layer (MovimientoFijoService).
 * 
 * Este servicio actúa como intermediario entre los repositorios y la capa de aplicación,
 * centralizando toda la lógica de consulta y transformación de datos de MovimientoFijo.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoFijo\Services
 * @since 1.0.0
 */
class MovimientoFijoQueryService
{
    public function __construct(
        private MovimientoFijoReadRepositoryContract $repository
    )
    {
    }

    /**
     * Obtiene todos los movimientos fijos con sus relaciones cargadas
     * 
     * @return Collection
     */
    public function getAllWithDetails(): Collection
    {
        return $this->repository->getAllWithDetails();
    }

    /**
     * Obtiene todos los movimientos fijos
     * 
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * Obtiene el conteo total de registros de movimientos fijos
     * 
     * @return int
     */
    public function getRecordsCount(): int
    {
        return $this->repository->getRecordsCount();
    }

    /**
     * Obtiene una página de resultados con paginación
     * 
     * @param TableQueryDTO $dto
     * @param array<string> $initialWheres
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(TableQueryDTO $dto, array $initialWheres = [])
    {
        return $this->repository->paginate($dto, $initialWheres);
    }

    /**
     * Busca un movimiento fijo por su ID
     * 
     * @param int $id
     * @return MovimientoFijo|null
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Ejecuta una búsqueda por atributo
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
