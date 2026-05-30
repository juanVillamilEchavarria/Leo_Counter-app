<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Configuracion\Enums;

/**
 * Enum para identificar a que tipo de repositorio del handler (write o read) 
 */
enum HandlerTypes : string{
    CASE WRITE = 'write';
    CASE READ = 'read';
}