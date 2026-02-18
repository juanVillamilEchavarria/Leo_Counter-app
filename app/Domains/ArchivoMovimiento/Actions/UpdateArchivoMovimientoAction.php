<?php

namespace App\Domains\ArchivoMovimiento\Actions;
use App\Shared\Abstracts\Actions\UpdateAction;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;
class UpdateArchivoMovimientoAction extends UpdateAction{
    public function __construct()
    {
        return parent::__construct(ArchivoMovimiento::class);
    }
}