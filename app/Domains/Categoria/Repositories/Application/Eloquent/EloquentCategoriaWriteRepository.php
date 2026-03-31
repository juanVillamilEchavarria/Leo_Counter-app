<?php

namespace App\Domains\Categoria\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\Categoria\Repositories\Contracts\CategoriaWriteRepositoryContract;
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
