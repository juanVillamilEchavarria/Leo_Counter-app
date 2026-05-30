<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Movimiento\Contracts\Events;

use App\Domains\Categoria\Aggregates\Categoria;
use App\Shared\Domain\Contracts\EventContract;
/**
 * Contrato que representa un evento que dispara la actualizacion de los comprobantes de un movimiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface UpdateAttachmentsForMovimientoEventContract extends EventContract
{
    /**
     * Obtiene los comprobantes existentes a mover y actualizar
     * @return array|null
     */
    public function getComprobantesExisting(): ?array;

    /**
     * Obtiene la categoria del movimiento
     * @return Categoria
     */
    public function getCategoria(): Categoria;

    /**
     * Obtiene el nombre del tipo de movimiento
     * @return string
     */
    public function getTipoMovimientoName(): string;

    /**
     * Obtiene si el path del archivo ha cambiado
     * @return bool
     */
    public function pathChanged(): bool;

}
