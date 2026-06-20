<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Domains\Auditoria\Enums;

/**
 * Enum que representa las tablas (dominios) que son auditables
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 */
enum AuditableTypes : string
{
    CASE MOVIMIENTOS = 'movimientos';
    CASE MOVIMIENTOS_PENDIENTES = 'movimientos_pendientes';
    CASE PRESUPUESTOS = 'presupuestos';

}
