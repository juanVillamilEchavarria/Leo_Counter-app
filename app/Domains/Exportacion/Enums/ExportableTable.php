<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Domains\Exportacion\Enums;

/**
 * Enum que representa las tablas (dominios) que son exportables a CSV o Excel.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
enum ExportableTable: string
{
    case MOVIMIENTOS = 'movimientos';
    case AUDITORIAS = 'auditorias';
    case PRESUPUESTOS = 'presupuestos';
    case CUENTAS = 'cuentas';
    case CATEGORIAS = 'categorias';
    case PROPIETARIOS = 'propietarios';
    case MOVIMIENTOS_FIJOS = 'movimientos_fijos';
    case MOVIMIENTOS_PENDIENTES = 'movimientos_pendientes';
    case TRANSFERENCIAS = 'transferencias';
}
