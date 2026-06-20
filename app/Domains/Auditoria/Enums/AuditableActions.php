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
 * Enum que encapsula los tipos de acciones auditables del sistema
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 */
enum AuditableActions : string
{
    CASE CREATE = 'create';
    CASE UPDATE = 'update';
    CASE DELETE = 'delete';

}
