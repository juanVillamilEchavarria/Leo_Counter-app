<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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

    public function map(callable $callback) : static
    {
        return parent::map($callback);
    }
    public function filter(?callable $callback = null): static
    {
        return parent::filter($callback);
    }
    public function getItems(): array
    {
        return $this->all();
    }
}