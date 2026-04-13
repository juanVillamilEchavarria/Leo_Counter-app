<?php

namespace App\Shared\Infrastructure\Framework\Laravel\Collections;

use App\Shared\Domain\Contracts\CollectionContract;
use Illuminate\Support\Collection;

/**
 * Adapter que implementa el contrato de colección del dominio
 * utilizando la Collection de Laravel como implementación subyacente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
class LaravelCollection extends Collection implements CollectionContract
{

    public static function make($collection = []): static
    {
        return new static($collection);
    }

    public function getItems(): array
    {
        return $this->all();
    }
}