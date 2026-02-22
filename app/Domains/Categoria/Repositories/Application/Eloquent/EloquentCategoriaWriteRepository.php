<?php

namespace App\Domains\Categoria\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\Categoria\Repositories\Contracts\CategoriaWriteRepositoryContract;
use App\Models\Categoria\Categoria;
use Illuminate\Database\Eloquent\Model;

class EloquentCategoriaWriteRepository extends EloquentWriteRepository implements CategoriaWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(Categoria::class);
    }
    public function toggleEsFijo(Categoria $categoria): bool
    {
        return $categoria->update(['es_fijo' => !$categoria->es_fijo]);
    }
}
