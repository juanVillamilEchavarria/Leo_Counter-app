<?php

namespace App\Domains\Categoria\Repositories\Contracts;

use App\Models\Categoria\Categoria;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;

interface CategoriaWriteRepositoryContract
{
    public function store(DTOContract $storeCategoriaDTO);
    public function update(Model $categoria, DTOContract $updateCategoriaDTO): bool;
    public function destroy(Model $categoria): bool;
    public function toggle(Model $categoria, string $attribute): bool;
}
