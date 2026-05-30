<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Configuracion\Strategies;
use App\Domains\Configuracion\Contracts\Strategies\SoftDeleteManagerContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Domains\Configuracion\Strategies\Abstracts\SoftDeleteManager;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;

/**
 * Manager de persistencia para registros eliminados de Cuenta.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Configuracion\Strategies
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SoftDeleteCuentaManager extends SoftDeleteManager implements SoftDeleteManagerContract{
    public function __construct(
        private DomainRecordCanBeDeletedCheckerContract $checker,
        CuentaRepositoryContract $writeRepository)
    {
         parent::__construct($writeRepository);
    }

    protected function normalizeId(string $id): AggregateModelIdContract
    {
        return new CuentaId($id);
    }

    public function supports(SoftDeleteManagerTypes $domainType): bool
    {
        return $domainType === SoftDeleteManagerTypes::CUENTAS;
    }

    public function canDelete(AggregateModelIdContract $id): bool
    {
        return $this->checker->canBeDeleted($id);
    }
}
