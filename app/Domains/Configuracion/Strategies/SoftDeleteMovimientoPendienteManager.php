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
use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;
use App\Domains\Configuracion\Contracts\Strategies\SoftDeleteManagerContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Domains\Configuracion\Strategies\Abstracts\SoftDeleteManager;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Manager de persistencia para registros eliminados de MovimientoPendiente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Configuracion\Strategies
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SoftDeleteMovimientoPendienteManager extends SoftDeleteManager implements SoftDeleteManagerContract{
    public function __construct(
       private DomainRecordCanBeDeletedCheckerContract $checker,
        MovimientoPendienteRepositoryContract $writeRepository
    ) {
        parent::__construct($writeRepository);
    }

    protected function normalizeId(string $id): AggregateModelIdContract
    {
        return new MovimientoPendienteId($id);
    }

    public function supports(SoftDeleteManagerTypes $domainType): bool
    {
        return $domainType === SoftDeleteManagerTypes::MOVIMIENTOS_PENDIENTES;
    }

    public function canDelete(AggregateModelIdContract $id): bool
    {
        return $this->checker->canBeDeleted($id);
    }
}
