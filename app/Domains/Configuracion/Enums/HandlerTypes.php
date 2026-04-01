<?php

namespace App\Domains\Configuracion\Enums;

/**
 * Enum para identificar a que tipo de repositorio del handler (write o read) 
 */
enum HandlerTypes : string{
    CASE WRITE = 'write';
    CASE READ = 'read';
}