<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\MovimientoPendiente\Framework\Laravel\Enricher;

use App\Application\MovimientoPendiente\Contracts\Enrichers\MovimientoPendienteCollectionEnricherContract;
use App\Application\MovimientoPendiente\DTOs\MovimientoPendienteForListDTO;
use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Domain\Services\Financial\BalanceCheckerService;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use Illuminate\Support\Collection;

/**
 * Enriquece una colección de movimientos pendientes con detalles adicionales.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\MovimientoPendiente\Enricher\Laravel
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelMovimientoPendienteCollectionEnricher implements MovimientoPendienteCollectionEnricherContract
{
    public function __construct(
        private BalanceCheckerService $balanceCheckerService
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function enrich(CollectionContract $movimientosPendientes, CollectionContract $accountsBalance): CollectionContract
    {
        /** @var Collection $formatedBalances - coleccion de los saldos formateadas a la coleccion de laravel para usar sus funciones nativas */
        $formatedBalances = collect($accountsBalance);

        /** @var Collection $mapped - la coleccion de registris ya mapeados a los DTO */
        $mapped = $movimientosPendientes->map(function (MovimientoPendiente $movimientoPendiente) use ($formatedBalances) {
            $accountBalance = $formatedBalances->firstWhere( 'id',$movimientoPendiente->cuenta_id);

            $enoughBalance = null;
            if ($accountBalance !== null) {
                $enoughBalance = $this->balanceCheckerService->canAfford(
                    new Amount((float) $accountBalance->saldo_actual),
                    new Amount((float) $movimientoPendiente->monto)
                );
            }

            return new MovimientoPendienteForListDTO(
                id: $movimientoPendiente->id,
                nombre: $movimientoPendiente->nombre,
                descripcion: $movimientoPendiente->descripcion,
                tipo_movimiento: $movimientoPendiente->tipo_movimiento?->tipo_movimiento,
                categoria: $movimientoPendiente->categoria?->nombre,
                cuenta: $movimientoPendiente->cuenta?->nombre,
                movimiento_fijo: $movimientoPendiente->movimiento_fijo?->nombre,
                fecha_programada: $movimientoPendiente->fecha_programada,
                monto: $movimientoPendiente->monto,
                estado: $movimientoPendiente->estado,
                dias_aviso: $movimientoPendiente->dias_aviso,
                enough_balance: $enoughBalance
            );
        });

        return LaravelCollection::make($mapped->values());
    }
}
