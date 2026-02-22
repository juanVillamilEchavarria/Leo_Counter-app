<?php

namespace App\Domains\Categoria\Repositories\Contracts;

use App\Models\Categoria\Categoria;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Abstracts\DTOs\DTO;

interface CategoriaWriteRepositoryContract
{
    public function store(DTO $storeCategoriaDTO);
    public function update(Model $categoria, DTO $updateCategoriaDTO): bool;
    public function destroy(Model $categoria): bool;
    public function toggleEsFijo(Categoria $categoria): bool;
}
