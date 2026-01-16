<?php

namespace App\Domains\Categoria\Services;

use App\Models\Categoria\Categoria;
use App\Domains\Categoria\Actions\StoreCategoriaAction;
use App\Domains\Categoria\Actions\UpdateCategoriaAction;    
use App\Domains\Categoria\Actions\DestroyCategoriaAction;
use App\Domains\Categoria\Actions\GetCategoriaAction;
use App\Domains\TipoMovimiento\Actions\GetTipoMovimientoAction;
use App\Domains\Categoria\DTOs\CategoriaFormOptionsDTO;
use App\Domains\Categoria\DTOs\StoreAndUpdateCategoriaDTO;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class CategoriaService{
    public function __construct(
        private StoreCategoriaAction $storeCategoriaAction,
        private UpdateCategoriaAction $updateCategoriaAction,
        private DestroyCategoriaAction $destroyCategoriaAction,
        private GetCategoriaAction $getCategoriaAction,
        private GetTipoMovimientoAction $getTipoMovimientoAction)
    {
    }

    public function store(array $data): Categoria{
        $dto = new StoreAndUpdateCategoriaDTO(
            nombre: $data['nombre'],
            tipo_movimiento_id: $data['tipo_movimiento_id'],
            descripcion: $data['descripcion']
        );
        return $this->storeCategoriaAction->store($dto);
    }

    public function update(Categoria $categoria, array $data): bool{
        $dto = new StoreAndUpdateCategoriaDTO(
            nombre: $data['nombre'],
            tipo_movimiento_id: $data['tipo_movimiento_id'],
            descripcion: $data['descripcion']
        );
        return $this->updateCategoriaAction->update($categoria, $dto);
    }

    public function destroy(Categoria $categoria): bool
    {
        return $this->destroyCategoriaAction->destroy($categoria);
    }

    public function toggleEsFijo(Categoria $categoria): bool
    {
        return $this->updateCategoriaAction->toggleEsFijo($categoria);
    }
    public function getOptions() : CategoriaFormOptionsDTO
    {
        return new CategoriaFormOptionsDTO(
            tipos: $this->getTipoMovimientoAction->getAll()
        );
    }

    public function getRecordsCount() : int{
        return $this->getCategoriaAction->getRecordsCount();
    }

    public function getAllWithDetails() : AnonymousResourceCollection
    {
        return $this->getCategoriaAction->getAllWithDetails();
    }
}