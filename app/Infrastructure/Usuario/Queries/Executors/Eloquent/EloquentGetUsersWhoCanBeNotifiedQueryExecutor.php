<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Usuario\Queries\Executors\Eloquent;

use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\Enums\Roles;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Models\Notificacion\SuscriptorNotificacion;
use App\Models\User;
use App\Shared\Application\Contracts\Queries\Executors\GetUsersWhoCanBeNotifiedQueryExecutorContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Domain\ValueObjects\Password;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

final readonly class EloquentGetUsersWhoCanBeNotifiedQueryExecutor implements GetUsersWhoCanBeNotifiedQueryExecutorContract
{

    /**
     * @inheritDoc
     */
    public function execute(): CollectionContract
    {
        $suscriptores = SuscriptorNotificacion::where('active', '=', true)
            ->where('verified_at', '!=', null)
            ->get();
        $suscriptoresIds = $suscriptores->pluck('user_id')->toArray();
        $users = User::whereIn('id',$suscriptoresIds)->get();
        $aggregates = $users->map(function (User $user) {
            return Usuario::reconstitute(
                id: new UsuarioId($user->id),
                name: $user->name,
                email: new Email($user->email),
                password: Password::fromHash($user->password),
                role: Roles::try($user->role)
            );
        });
        return LaravelCollection::make($aggregates);
    }
}
