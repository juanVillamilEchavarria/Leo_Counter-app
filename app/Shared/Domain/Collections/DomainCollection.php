<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Domain\Collections;

use ArrayIterator;
use IteratorAggregate;
use Countable;
/**
 * Clase Adaptadora de Coleccion de dominio, la cual se encarga de representar una coleccion de datos 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Domain\Collections
 * @since 1.0.0
 * @version 1.0.0
 */

class DomainCollection implements  IteratorAggregate, Countable{

     /**
      * Implementacion real de la coleccion
      * @var array<int, mixed>
      */
    private array $items;

    /**
     * @param iterable<mixed> $collection
     */
    public function __construct(iterable $collection = [])
    {
        $this->items = is_array($collection)
            ? array_values($collection)
            : array_values(iterator_to_array($collection));
    }

    /**
     * Crea una nueva instancia de la coleccion
     * @param iterable<mixed> $collection
     * @return static
     */
    public static function make(iterable $collection = []): static {
         return new static($collection);
    }
    /**
     * Devuelve los items de la coleccion
     * @return array<int, mixed>
     */
    public function getItems(): array {
         return $this->items;
    }

    /**
     * Devuelve el iterador de la coleccion
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator {
         return new ArrayIterator($this->items);
        }
        /**
         * Devuelve la cantidad de items de la coleccion
         * @return int
         */
    public function count(): int {
         return count($this->items);
    }
    /**
     * Devuelve los items de la coleccion en un array
     * @return array
     */
    public function toArray(): array {
         return $this->items;
    }
    /**
     * Mapea los items de la coleccion
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback): static { 
        return new static(array_map($callback, $this->items));
    }
    /**
     * Filtro los items de la coleccion
     * @param callable $callback
     */
    public function filter(callable $callback): static {
         return new static(array_values(array_filter($this->items, $callback)));
     }
     /**
      * Suma los items de la coleccion
      * @param callable $callback
      */
    protected function sum(?callable $callback = null): float {
         if ($callback === null) {
             return (float) array_sum($this->items);
         }

         $sum = 0.0;

         foreach ($this->items as $item) {
             $sum += (float) $callback($item);
         }

         return $sum;
    }
    /**
     * Calcula el promedio de los items de la coleccion
     * @param callable $callback
     * @return float
     */

    protected function avg(?callable $callback = null): float {
         if ($this->items === []) {
             return 0.0;
         }

         return $this->sum($callback) / count($this->items);
    }

}
