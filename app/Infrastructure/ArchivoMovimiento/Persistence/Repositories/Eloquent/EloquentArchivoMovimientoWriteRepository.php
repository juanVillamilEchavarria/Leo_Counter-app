<?php

namespace App\Infrastructure\ArchivoMovimiento\Persistence\Repositories\Eloquent;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\ArchivoMovimiento\Contracts\Repositories\ArchivoMovimientoWriteRepositoryContract;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;

class EloquentArchivoMovimientoWriteRepository extends EloquentWriteRepository implements ArchivoMovimientoWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(ArchivoMovimiento::class);
    }
}
