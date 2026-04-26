<?php

namespace App\Infrastructure\Persistence\Strategies\SoftDeleteManagers\Cuenta;
use App\Infrastructure\AbstractPersistence\Strategies\SoftDeleteManager;
use App\Domains\Configuracion\Contracts\Strategies\SoftDeleteManagerContract;
use App\Domains\Cuenta\Contracts\Repositories\CuentaReadRepositoryContract;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Http\Resources\Configuracion\SoftDeletesManagers\Cuenta\DeletedCuentasResource;

class SoftDeleteCuentaManager extends SoftDeleteManager implements SoftDeleteManagerContract{
    protected SoftDeleteManagerTypes $domainType = SoftDeleteManagerTypes::CUENTAS;
    protected ?string $resource = DeletedCuentasResource::class;
    public function __construct(
        CuentaReadRepositoryContract $readRepository, 
        CuentaRepositoryContract $writeRepository)
    {
         parent::__construct($readRepository, $writeRepository);
    }
}