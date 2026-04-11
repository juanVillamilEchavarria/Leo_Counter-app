<?php

namespace App\Shared\Domain\Collections;

use Illuminate\Support\Collection as LaravelCollection;
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
      * @var LaravelCollection
      */
    private LaravelCollection $items;

    public function __construct(array | LaravelCollection $collection = [])
    {
        $this->items = $collection instanceof LaravelCollection ? $collection : new LaravelCollection($collection);
    }

    /**
     * Crea una nueva instancia de la coleccion
     * @param array|LaravelCollection $collection
     * @return static
     */
    public static function make(array | LaravelCollection $collection = []): static {
         return new static($collection);
    }
    /**
     * Devuelve los items de la coleccion
     * @return LaravelCollection
     */
    public function getItems(): LaravelCollection {
         return $this->items;
    }

    /**
     * Devuelve el iterador de la coleccion
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator {
         return new ArrayIterator($this->items->all()); 
        }
        /**
         * Devuelve la cantidad de items de la coleccion
         * @return int
         */
    public function count(): int {
         return $this->items->count(); 
    }
    /**
     * Devuelve los items de la coleccion en un array
     * @return array
     */
    public function toArray(): array {
         return $this->items->all(); 
    }
    /**
     * Mapea los items de la coleccion
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback): static { 
        return new static($this->items->map($callback)); 
    }
    /**
     * Filtro los items de la coleccion
     * @param callable $callback
     */
    public function filter(callable $callback): static {
         return new static($this->items->filter($callback));
     }
     /**
      * Suma los items de la coleccion
      * @param callable $callback
      */
    protected function sum(?callable $callback = null): float {
         return $this->items->sum($callback); 
    }
    /**
     * Calcula el promedio de los items de la coleccion
     * @param callable $callback
     * @return float
     */

    protected function avg(?callable $callback = null): float {
         return $this->items->avg($callback); 
    }

}