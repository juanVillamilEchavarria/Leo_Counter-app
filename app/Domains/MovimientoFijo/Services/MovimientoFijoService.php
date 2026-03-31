<?php 

/**
 * DEPRECATED: Este archivo ha sido movido a la arquitectura de servicios adecuada.
 * 
 * Usa:
 * - App\Domains\MovimientoFijo\Services\Application\MovimientoFijoService (para orquestación)
 * - App\Domains\MovimientoFijo\Services\Domain\MovimientoFijoQueryService (para consultas)
 * 
 * Este alias se mantiene para compatibilidad hacia atrás durante la transición.
 */

namespace App\Domains\MovimientoFijo\Services;

use App\Domains\MovimientoFijo\Services\Application\MovimientoFijoService as NewMovimientoFijoService;

/**
 * Alias hacia la nueva ubicación del servicio
 * @deprecated Usa App\Domains\MovimientoFijo\Services\Application\MovimientoFijoService en su lugar
 */
class MovimientoFijoService extends NewMovimientoFijoService
{
}