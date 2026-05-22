<?php

namespace App\Domains\Usuario\Enums;

/**
 * Enum que representa los roles disponibles para un usuario del sistema.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Usuario\Enums
 * @since 1.0.0
 * @version 1.0.0
 */
enum Roles: string
{
    case ADMIN = 'admin';
    case MEMBER = 'member';
    public static function try(string $role){
        return match($role){
            'admin' => self::ADMIN,
            'member' => self::MEMBER,
            default => throw new \InvalidArgumentException('rol no encontrado')
        };
    }
}
