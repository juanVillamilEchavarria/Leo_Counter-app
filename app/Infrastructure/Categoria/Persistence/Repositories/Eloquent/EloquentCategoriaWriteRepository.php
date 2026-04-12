<?php

namespace App\Infrastructure\Categoria\Persistence\Repositories\Eloquent;

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
