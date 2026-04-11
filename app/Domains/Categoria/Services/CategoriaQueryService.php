<?php

namespace App\Domains\Categoria\Services;

use App\Models\Categoria\Categoria;
use App\Domains\Categoria\Contracts\Repositories\CategoriaReadRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

/**
 * CategoriaQueryService
 * 
 * Servicio de dominio encargado de delegación de responsabilidades de lectura
 * desde el Repository hacia la Application Layer (CategoriaService).
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Categoria\Services
 * @since 1.0.0
 */
class CategoriaQueryService
{
    public function __construct(
        private CategoriaReadRepositoryContract $repository
    )
    {
    }

    /**
     * Obtiene todas las categorías con detalles completos
     * 
     * @return Collection
     */
    public function getAllWithFullDetails(): Collection
    {
        return $this->repository->getAllWithFullDetails();
    }

    /**
     * Obtiene el conteo total de categorías
     * 
     * @return int
     */
    public function getRecordsCount(): int
    {
        return $this->repository->getRecordsCount();
    }

    /**
     * Busca categorías iguales por nombre y tipo de movimiento
     * 
     * @param string $nombre
     * @param int $tipoMovimientoId
     * @return mixed
     */
    public function getEqual(string $nombre, int $tipoMovimientoId)
    {
        return $this->repository->getEqual($nombre, $tipoMovimientoId);
    }

    /**
     * Busca una categoría por ID
     * 
     * @param int $id
     * @return Categoria|null
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Busca categorías por atributo
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
