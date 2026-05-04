<?php

namespace App\Infrastructure\ArchivoMovimiento\Persistence\Repositories\Eloquent;

use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\ArchivoMovimiento\Contracts\Repositories\ArchivoMovimientoRepositoryContract;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;

class EloquentArchivoMovimientoRepository extends EloquentRepository implements ArchivoMovimientoRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(ArchivoMovimiento::class);
    }
}
