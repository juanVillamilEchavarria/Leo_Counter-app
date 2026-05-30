<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Contracts\Enrichers;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato para enriquecer una coleccion de movimientos pendientes con los parametros necesarios para mostrar en el listado de movimientos pendientes (capa de presentacion).
 * @package App\Application\MovimientoPendiente\Contracts\Enrichers
 * @version 1.0.0
 * @since 1.0.0
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
interface MovimientoPendienteCollectionEnricherContract{

    /**
     * Devuelve una nueva coleccion enriquecida de DTOs con los parametros necesarios para mostrar en el listado de movimientos pendientes (capa de presentacion).
     * Instancia propiedades como si la cuenta asociada al movimiento, tiene suficiente saldo para realizar el movimiento.
     * @param CollectionContract $movimientosPendientes - El listado de movimientos pendientes
     * @param CollectionContract $accountsBalance - El listado de saldos de las cuentas
     * @return CollectionContract - una coleccion enriquecida de DTOs
     */
    public function enrich(CollectionContract $movimientosPendientes, CollectionContract $accountsBalance): CollectionContract;
}
