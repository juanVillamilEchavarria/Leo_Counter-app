<?php

namespace App\Infrastructure\Persistence\Strategies\SoftDeleteManagers\MovimientoPendiente;
use App\Infrastructure\AbstractPersistence\Strategies\SoftDeleteManager;
use App\Domains\Configuracion\Contracts\Strategies\SoftDeleteManagerContract;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteReadRepositoryContract;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteWriteRepositoryContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Http\Resources\Configuracion\SoftDeletesManagers\MovimientoPendiente\DeletedMovimientoPendientesResource;
use Illuminate\Database\Eloquent\Model;

class SoftDeleteMovimientoPendienteManager extends SoftDeleteManager implements SoftDeleteManagerContract{
    protected SoftDeleteManagerTypes $domainType = SoftDeleteManagerTypes::MOVIMIENTOS_PENDIENTES;
    protected ?string $resource = DeletedMovimientoPendientesResource::class;
    public function __construct(
        MovimientoPendienteReadRepositoryContract $readRepository,
        MovimientoPendienteWriteRepositoryContract $writeRepository
    ) {
        parent::__construct($readRepository, $writeRepository);
    }

    public function canDelete(Model $model): bool
    {
        return true;// aqui es true, porque las relaciones de esta tabla, son de tablas externas a que apuntan a esta, no de esta a otras, es decir, en ninguna tabla existe aun, movimientoPendiente_id, pues en la tabla movimientos, cuando se inserta un movimiento desde un MovimientoPendiente, automaticamente ya aparece en la tabla de MovimeintoPendiente como pagado, asi que en la UI del sistema ya no aparece en los registros, pues solo se muestran los Pendientes, asi que nunca se podra eliminar un movimeintoPendiente que ya este ingresado en Movimeintos
    }
}
