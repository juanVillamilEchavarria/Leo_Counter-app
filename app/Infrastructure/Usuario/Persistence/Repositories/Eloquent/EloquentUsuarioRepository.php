<?php

namespace App\Infrastructure\Usuario\Persistence\Repositories\Eloquent;

use App\Domains\Usuario\Aggregates\Usuario as UsuarioAggregate;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\Enums\Roles;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Models\User;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Shared\ValueObjects\Password;
use Illuminate\Database\Eloquent\Model;

/**
 * Repositorio Eloquent de escritura para el agregado Usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Usuario\Persistence\Repositories\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final class EloquentUsuarioRepository extends EloquentRepository implements UsuarioRepositoryContract
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    /**
     * Convierte el agregado Usuario en atributos persistibles.
     *
     * @param object $aggregate Agregado Usuario.
     * @return array<string, mixed>
     */
    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof UsuarioAggregate, 'El agregado debe ser una instancia de UsuarioAggregate');

        return [
            'id' => $aggregate->getId()->getValue(),
            'name' => $aggregate->getName(),
            'email' => $aggregate->getEmail()->__toString(),
            'password' => $aggregate->getPassword()->__toString(),
            'role' => $aggregate->getRole()->value,
        ];
    }

    /**
     * Reconstituye el agregado Usuario desde un modelo Eloquent.
     *
     * @param Model $model Registro de base de datos.
     * @return UsuarioAggregate
     */
    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return UsuarioAggregate::reconstitute(
            id: new UsuarioId($model->id),
            name: $model->name,
            email: new Email($model->email),
            password:  Password::fromHash($model->password),
            role: Roles::try($model->role),
        );
    }

    /**
     * Busca un usuario por correo electronico y lo reconstituye como agregado.
     *
     * @param Email $email Correo electronico del usuario.
     * @return UsuarioAggregate|null Usuario encontrado o null.
     */
    public function findByEmail(Email $email): ?UsuarioAggregate
    {
        $model = User::where('email', $email->__toString())->first();

        return $model ? $this->mapDatabaseRecordToAggregate($model) : null;
    }

}
