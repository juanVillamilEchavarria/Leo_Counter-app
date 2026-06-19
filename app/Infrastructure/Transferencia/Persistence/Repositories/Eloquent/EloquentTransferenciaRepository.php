<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Infrastructure\Transferencia\Persistence\Repositories\Eloquent;

use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Transferencia\ValueObjects\TransferenciaId;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Transferencia\Contracts\Repositories\TransferenciaRepositoryContract;
use App\Models\Transferencia\Transferencia as TransferenciaModel;
use App\Domains\Transferencia\Aggregates\Transferencia as TransferenciaAggregate;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Implementacion del repositorio de transferencia usando eloquent ORM.
 *
 * @package App\Infrastructure\Transferencia\Persistence\Repositories\Eloquent
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.1
 * @since 1.0.1
 */
class EloquentTransferenciaRepository extends EloquentRepository implements TransferenciaRepositoryContract
{
    public function __construct(
        private EventBus $eventBus
    ) {
        parent::__construct(TransferenciaModel::class);
    }

    public function store(AggregateModelContract $model): AggregateModelContract
    {
        $events = [];
        if (method_exists($model, 'releaseEvents')) {
            $events = $model->releaseEvents();
        }
        $stored = parent::store($model);

        if (!empty($events)) {
            $this->eventBus->publishMany($events);
        }

        return $stored;
    }

    public function destroy(AggregateModelIdContract $id): bool
    {
        return false;
    }

    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof TransferenciaAggregate);
        return [
            'id' => $aggregate->getId()->getValue(),
            'cuenta_enviadora_id' => $aggregate->getCuentaEnviadoraId()->getValue(),
            'cuenta_receptora_id' => $aggregate->getCuentaReceptoraId()->getValue(),
            'monto' => $aggregate->getMonto()->getValue(),
            'fecha' => $aggregate->getFecha()->format('Y-m-d H:i:s'),
            'descripcion' => $aggregate->getDescripcion(),
        ];
    }

    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return TransferenciaAggregate::reconstitute(
            id: new TransferenciaId($model->id),
            cuenta_enviadora_id: new CuentaId($model->cuenta_enviadora_id),
            cuenta_receptora_id: new CuentaId($model->cuenta_receptora_id),
            monto: new Amount($model->monto),
            fecha: new Date(new \DateTimeImmutable($model->fecha)),
            descripcion: (string) $model->descripcion
        );
    }
}
