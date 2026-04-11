<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\Categoria;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\Categoria\Contracts\Repositories\CategoriaWriteRepositoryContract;
use App\Models\Categoria\Categoria;

class EloquentCategoriaWriteRepository extends EloquentWriteRepository implements CategoriaWriteRepositoryContract
{
    protected array $toggeable = [
        'es_fijo'
    ];

    public function __construct()
    {
        return parent::__construct(Categoria::class);
    }
}
