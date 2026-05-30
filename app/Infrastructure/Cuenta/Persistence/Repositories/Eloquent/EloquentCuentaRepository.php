<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Cuenta\Persistence\Repositories\Eloquent;

use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Models\Cuenta\Cuenta;
use App\Domains\Cuenta\Aggregates\Cuenta as CuentaAggregate;
use App\Shared\Domain\Contracts\AggregateModelContract;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Cuenta\ValueObjects\CuentaId;

class EloquentCuentaRepository extends EloquentRepository implements CuentaRepositoryContract
{
    protected array $toggeable = [
        'active',
        'archived',
    ];

    /**
     * @param CuentaAggregate $aggregate
     */
    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof CuentaAggregate, 'El argumento debe ser una instancia de CuentaAggregate');
        return [
            'id' => $aggregate->getId()->getValue(),
            'nombre' => $aggregate->getNombre(),
            'notas' => $aggregate->getNotas(),
            'saldo_inicial' => $aggregate->getSaldoInicial(),
            'saldo_actual' => $aggregate->getSaldoActual(),
            'propietario_id' => $aggregate->getPropietarioId(),
            'tipo_cuenta_id' => $aggregate->getTipoCuentaId(),
            'active' => $aggregate->getActive(),
        ];
    }

    /**
     * @param Cuenta $model
     * @return CuentaAggregate
     */
    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return CuentaAggregate::reconstitute(
            id: new CuentaId($model->id),
            nombre: $model->nombre,
            notas: $model->notas,
            saldo_inicial: $model->saldo_inicial,
            saldo_actual: $model->saldo_actual,
            active: $model->active,
            propietario_id: $model->propietario_id,
            tipo_cuenta_id: $model->tipo_cuenta_id,
        );
    }

    public function __construct()
    {
        return parent::__construct(Cuenta::class);
    }
}
