<?php

namespace App\Application\Categoria\Services;

use App\Models\Categoria\Categoria;
use App\Domains\Categoria\Services\CategoriaQueryService;
use App\Domains\Categoria\Contracts\Repositories\CategoriaWriteRepositoryContract;
use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoReadRepositoryContract;
use App\Application\Categoria\DTOs\CategoriaFormOptionsDTO;
use App\Application\Categoria\DTOs\StoreAndUpdateCategoriaDTO;
use App\Domains\Categoria\Exceptions\CannotStoreCategoriaException;
use App\Http\Resources\Categoria\CategoriaResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * CategoriaService
 * 
 * Servicio de aplicación encargado de coordinar operaciones relacionadas con Categoria.
 * Delega responsabilidades de lectura al CategoriaQueryService y de escritura al Repository.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Services
 * @since 1.0.0
 */
class CategoriaService
{
    public function __construct(
        private CategoriaQueryService $categoriaQueryService,
        private CategoriaWriteRepositoryContract $categoriaWriteRepository,
        private TipoMovimientoReadRepositoryContract $tipoMovimientoReadRepository
    )
    {
    }

    /**
     * Valida si se puede almacenar una categoría
     * 
     * @param StoreAndUpdateCategoriaDTO $dto
     * @return void
     * @throws CannotStoreCategoriaException
     */
    private function storeValidate(StoreAndUpdateCategoriaDTO $dto): void
    {
        if ($this->categoriaQueryService->getEqual($dto->nombre, $dto->tipo_movimiento_id)->exists()) {
            throw new CannotStoreCategoriaException();
        }
    }

    /**
     * Crea una nueva categoría
     * 
     * @param array $data
     * @return Categoria
     */
    public function store(array $data): Categoria
    {
        $dto = StoreAndUpdateCategoriaDTO::fromArray($data);
        $this->storeValidate($dto);
        return $this->categoriaWriteRepository->store($dto);
    }

    /**
     * Actualiza una categoría existente
     * 
     * @param Categoria $categoria
     * @param array $data
     * @return bool
     */
    public function update(Categoria $categoria, array $data): bool
    {
        $dto = StoreAndUpdateCategoriaDTO::fromArray($data);
        return $this->categoriaWriteRepository->update($categoria, $dto);
    }

    /**
     * Elimina una categoría
     * 
     * @param Categoria $categoria
     * @return bool
     */
    public function destroy(Categoria $categoria): bool
    {
        return $this->categoriaWriteRepository->destroy($categoria);
    }

    /**
     * Alterna el estado es_fijo de una categoría
     * 
     * @param Categoria $categoria
     * @return bool
     */
    public function toggleEsFijo(Categoria $categoria): bool
    {
        return $this->categoriaWriteRepository->toggle($categoria, 'es_fijo');
    }

    /**
     * Obtiene las opciones para el formulario
     * 
     * @return CategoriaFormOptionsDTO
     */
    public function getOptions(): CategoriaFormOptionsDTO
    {
        return new CategoriaFormOptionsDTO(
            tipos: $this->tipoMovimientoReadRepository->getAll()
        );
    }

    /**
     * Obtiene el conteo total de categorías
     * Delega al QueryService
     * 
     * @return int
     */
    public function getRecordsCount(): int
    {
        return $this->categoriaQueryService->getRecordsCount();
    }

    /**
     * Obtiene todas las categorías con detalles
     * Delega al QueryService
     * 
     * @return AnonymousResourceCollection
     */
    public function getAllWithDetails(): AnonymousResourceCollection
    {
        $categorias = $this->categoriaQueryService->getAllWithFullDetails();
        return CategoriaResource::collection($categorias);
    }
}
