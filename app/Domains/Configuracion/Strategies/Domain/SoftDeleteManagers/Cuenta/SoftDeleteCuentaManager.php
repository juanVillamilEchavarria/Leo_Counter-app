<?php

namespace App\Domains\Configuracion\Strategies\Domain\SoftDeleteManagers\Cuenta;
use App\Domains\Configuracion\Strategies\Abstracts\SoftDeleteManager;
use App\Domains\Configuracion\Strategies\Contracts\SoftDeleteManagerContract;
use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
use App\Domains\Cuenta\Repositories\Contracts\CuentaWriteRepositoryContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Domains\Configuracion\Resources\SoftDeletesManagers\Cuenta\DeletedCuentasResource;

class SoftDeleteCuentaManager extends SoftDeleteManager implements SoftDeleteManagerContract{
    protected SoftDeleteManagerTypes $domainType = SoftDeleteManagerTypes::CUENTAS;
    protected ?string $resource = DeletedCuentasResource::class;
    public function __construct(
        CuentaReadRepositoryContract $readRepository, 
        CuentaWriteRepositoryContract $writeRepository)
    {
         parent::__construct($readRepository, $writeRepository);
    }
}