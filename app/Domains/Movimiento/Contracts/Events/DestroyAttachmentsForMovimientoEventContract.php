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

use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;
use App\Shared\Domain\Contracts\EventContract;

/**
 * Contrato que representa un evento que dispara la eliminacion de los comprobantes de un movimiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface DestroyAttachmentsForMovimientoEventContract extends EventContract
{
    /**
     * Obtiene los ids de los comprobantes a eliminar
     * @return array<ArchivoMovimientoId>|null
     */
    public function getComprobantesDeleteIds():?array;

}
