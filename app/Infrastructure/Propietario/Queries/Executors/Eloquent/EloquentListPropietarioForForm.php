<?php

namespace App\Infrastructure\Propietario\Queries\Executors\Eloquent;

use App\Application\Cuenta\Contracts\Queries\Executors\FormOptions\ListPropietarioForFormContract;
use App\Models\Propietario\Propietario;
use App\Shared\Application\Contracts\Queries\QueryContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Ejecutor de consulta para listar propietarios para opciones de formulario usando Eloquent ORM.
 * @author JuanVillamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Propietario\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListPropietarioForForm implements ListPropietarioForFormContract
{
    public function execute(): CollectionContract
    {
        $propietarios = Propietario::all(['id', 'nombre']);

        return new LaravelCollection($propietarios);
    }
}