<?php

namespace App\Application\Notificacion\DTOs;

use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Data Transfer Object para las opciones de formulario de suscriptores
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Notificacion\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SuscriptoresFormOptionsDTO
{
    /**
     * @param CollectionContract $usuarios - los usuarios del sistema
     * no se obtienenen por ahora en este objeto los canales, debido a que ya se envian en el index de la pagina, asi evitamos doble query, es decir, el frontend ya tiene los canales
     */
    public function __construct(
        public CollectionContract $usuarios,
        public CollectionContract $canales
    )
    {
    }

}
