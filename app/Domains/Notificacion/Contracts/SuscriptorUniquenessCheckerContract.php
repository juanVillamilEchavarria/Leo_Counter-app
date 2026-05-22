<?php

namespace App\Domains\Notificacion\Contracts;

/**
 * Contrato para verificar la unicidad de una suscripción (user_id + canal_notificacion_id).
 * Implementado por la infraestructura (Eloquent checker).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Notificacion\Contracts
 * @since 1.0.0
 * @version 1.0.0
 */
interface SuscriptorUniquenessCheckerContract
{
    /**
     * Retorna true si ya existe una suscripción para el par usuario-canal.
     * @param string $userId
     * @param string $canalId
     * @param string|null $excludeId id a excluir (para updates)
     */
    public function exists(string $userId, string $canalId, ?string $excludeId = null): bool;
}
