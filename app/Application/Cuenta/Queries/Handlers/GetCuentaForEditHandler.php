<?php

namespace App\Application\Cuenta\Queries\Handlers;


use App\Domains\Cuenta\Contracts\CuentaCanUpdateSaldoInicialCheckerContract;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Application\Cuenta\Queries\GetCuentaForEditQuery;
use App\Domains\Cuenta\Exceptions\CannotFindCuentaException;
use App\Application\Cuenta\DTOs\CuentaEditDTO;

final readonly class GetCuentaForEditHandler{
    public function __construct(
        private CuentaCanUpdateSaldoInicialCheckerContract $checker,
        private CuentaRepositoryContract $repository
    )
    {
    }

    public function __invoke( GetCuentaForEditQuery $query ): CuentaEditDTO
    {
        $existing = $this->repository->findById($query->id);
        if (!$existing) {
            throw new CannotFindCuentaException(); 
        }
        return new CuentaEditDTO(
            id: $query->id,
            nombre: $existing->getNombre(),
            notas: $existing->getNotas(),
            saldo_inicial: $existing->getSaldoInicial(),
            propietario_id: $existing->getPropietarioId(),
            tipo_cuenta_id: $existing->getTipoCuentaId(),
            can_update_saldo: $this->checker->canUpdateSaldoInicial($query->id),
        );
        
    }

}