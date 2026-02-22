<?php

namespace App\Domains\ArchivoMovimiento\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\ArchivoMovimiento\Repositories\Contracts\ArchivoMovimientoWriteRepositoryContract;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;

class EloquentArchivoMovimientoWriteRepository extends EloquentWriteRepository implements ArchivoMovimientoWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(ArchivoMovimiento::class);
    }
}
