<?php

namespace App\Shared\Application\Contracts\Queries;

/**
 * Contrato base para todas las queries (DTOs de consulta) en la aplicación.
 * Este contrato se utiliza para marcar las clases que representan un caso de uso de consulta.
 * 
 * Cada query contract de cada aplicacion debe implementar este contrato padre para ser reconocido como un query válido en el sistema y poder ser manejado por el query bus.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Application\Contracts\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
interface QueryContract{

}