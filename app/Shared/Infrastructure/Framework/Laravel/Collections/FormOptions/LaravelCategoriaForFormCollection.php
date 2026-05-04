<?php

namespace App\Shared\Infrastructure\Framework\Laravel\Collections\FormOptions;

use App\Shared\Application\Contracts\Collections\FormOptions\CategoriaForFormCollectionContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use Override;

/**
 * Implementación Laravel de la colección de categorias para mostrar como opcion de un formulario.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Infrastructure\Framework\Laravel\Collections\FormOptions
 * @since 1.0.0
 * @version 1.0.0
 */
final class LaravelCategoriaForFormCollection extends LaravelCollection implements CategoriaForFormCollectionContract
{
    #[Override]
    public function ingresos(): CollectionContract
    {
        return LaravelCollection::make($this->where('tipo_movimiento_id', TipoMovimientoEnum::INGRESO->value)->values());
    }
    #[Override]
    public function gastos(): CollectionContract
    {
        return LaravelCollection::make($this->where('tipo_movimiento_id', TipoMovimientoEnum::GASTO->value)->values());
    }
}