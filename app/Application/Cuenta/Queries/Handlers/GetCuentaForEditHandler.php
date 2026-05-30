<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Cuenta\Queries\Handlers;


use App\Domains\Cuenta\Contracts\CuentaCanUpdateSaldoInicialCheckerContract;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Application\Cuenta\Queries\GetCuentaForEditQuery;
use App\Domains\Cuenta\Exceptions\CannotFindCuentaException;
use App\Application\Cuenta\DTOs\CuentaEditDTO;
use App\Domains\Cuenta\ValueObjects\CuentaId;

final readonly class GetCuentaForEditHandler{
    public function __construct(
        private CuentaCanUpdateSaldoInicialCheckerContract $checker,
        private CuentaRepositoryContract $repository
    )
    {
    }

    public function __invoke( GetCuentaForEditQuery $query ): CuentaEditDTO
    {
        $id= new CuentaId($query->id);
        $existing = $this->repository->findById($id);
        if (!$existing) {
            throw new CannotFindCuentaException();
        }
        return new CuentaEditDTO(
            id: $id->getValue(),
            nombre: $existing->getNombre(),
            notas: $existing->getNotas(),
            saldo_inicial: $existing->getSaldoInicial(),
            propietario_id: $existing->getPropietarioId(),
            tipo_cuenta_id: $existing->getTipoCuentaId(),
            can_update_saldo: $this->checker->canUpdateSaldoInicial($id),
        );

    }

}
