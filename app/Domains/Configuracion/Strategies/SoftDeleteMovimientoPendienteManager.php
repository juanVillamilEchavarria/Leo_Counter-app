<?php

namespace App\Domains\Configuracion\Strategies;
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
        return true;// aqui es true, porque las relaciones de esta tabla, son de tablas externas a que apuntan a esta, no de esta a otras, es decir, en ninguna tabla existe aun, movimientoPendiente_id, pues en la tabla movimientos, cuando se inserta un movimiento desde un MovimientoPendiente, automaticamente ya aparece en la tabla de MovimeintoPendiente como pagado, asi que en la UI del sistema ya no aparece en los registros, pues solo se muestran los Pendientes, asi que nunca se podra eliminar un movimeintoPendiente que ya este ingresado en Movimeintos
    }
}
