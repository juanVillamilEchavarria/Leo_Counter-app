<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Notificacion\Contracts\Strategies;

use App\Domains\Notificacion\Contracts\Events\SendVerificationToSuscriptorEventContract;
use App\Domains\Notificacion\Events\SuscriptorCreated;

/**
 * Contrato para la estrategia de manejadores de envio de verificacion para el suscriptor de notificaciones
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface SendVerificationToSuscriptorStrategyContract
{
    /**
     * Determina si la estrategia es compatible con el evento
     * @param SendVerificationToSuscriptorEventContract $event
     * @return bool
     */
    public function supports (SendVerificationToSuscriptorEventContract $event): bool;

    /**
     * Envia la  verificacion al suscriptor
     * @param SendVerificationToSuscriptorEventContract $event
     * @return void
     */
    public function sendVerification( SendVerificationToSuscriptorEventContract $event): void;

}
