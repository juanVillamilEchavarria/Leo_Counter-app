<?php

namespace App\Shared\Domain\Contracts;
/**
 * Contrato que representa una coleccion de items de un dominio
 * la implementacion real depende de infraestructura que debe usar este contrato
 * se debe crear un adapter para implementar la funcionalidad real de este contrato
 * Ejemplo de adapter : crear un LaravelCollection que implemente este contrato pero por dentro utilice el Collection del framework
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Domain\Collections
 * @since 1.0.0
 * @version 1.0.0
 */
interface CollectionContract{
    /**
     * Crea una nueva instancia de la coleccion
     * @param iterable<mixed> $collection
     * @return static
     */
    public static function make(iterable $collection = []): static;
    /**
     * Devuelve los items de la coleccion
     * @return array<int, mixed>
     */
    public function getItems(): array ;

    /**
     * Devuelve la cantidad de items de la coleccion
     * @return int
     */
    public function count(): int ;
    /**
     * Devuelve los items de la coleccion en un array
     * @return array
     */
    public function toArray() ;
    /**
     * Mapea los items de la coleccion
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback): static ;
    /**
     * Filtro los items de la coleccion
     * @param callable $callback
     */
    public function filter(callable $callback): static ;
}