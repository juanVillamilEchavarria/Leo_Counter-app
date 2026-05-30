<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Propietario\Persistence\Repositories\Eloquent;

use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Propietario\Contracts\Repositories\PropietarioRepositoryContract;
use App\Models\Propietario\Propietario;
use App\Domains\Propietario\Aggregates\Propietario as PropietarioAggregate;
use App\Domains\Propietario\ValueObjects\PropietarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Email;
use Illuminate\Database\Eloquent\Model;

class EloquentPropietarioRepository extends EloquentRepository implements PropietarioRepositoryContract
{
    /**
     * Convierte el agregado Propietario en atributos para persistencia.
     * @param object $aggregate
     * @return array<string, mixed>
     */
    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof PropietarioAggregate, 'El agregado debe ser una instancia de PropietarioAggregate');

        return [
            'id' => $aggregate->getId()->getValue(),
            'nombre' => $aggregate->getNombre(),
            'apellido' => $aggregate->getApellido(),
            'telefono' => $aggregate->getTelefono(),
            'email' => (string) $aggregate->getEmail(),
        ];
    }

    /**
     * Convierte el modelo de base de datos en el agregado Propietario.
     * @param Model $model
     * @return AggregateModelContract
     */
    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return PropietarioAggregate::reconstitute(
            id: new PropietarioId($model->id),
            nombre: $model->nombre,
            apellido: $model->apellido,
            telefono: $model->telefono,
            email: new Email($model->email),
        );
    }

    public function __construct()
    {
        return parent::__construct(Propietario::class);
    }
}
