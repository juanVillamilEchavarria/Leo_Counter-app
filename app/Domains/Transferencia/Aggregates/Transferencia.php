<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Domains\Transferencia\Aggregates;

use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\Contracts\EventContract;
use App\Domains\Transferencia\Events\TransferenciaCreated;
use App\Domains\Transferencia\ValueObjects\TransferenciaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Agregado de dominio de una transferencia
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 */
final readonly class Transferencia implements AggregateModelContract
{
    use \App\Shared\Domain\Traits\RecordsEvents;
    public function __construct(
        private TransferenciaId $id,
        private CuentaId $cuenta_enviadora_id,
        private CuentaId $cuenta_receptora_id,
        private Amount $monto,
        private Date $fecha,
        private string $descripcion
    )
    {
    }

    /**
     * Crea una nueva transferencia
     * @param TransferenciaId $id
     * @param CuentaId $cuenta_enviadora_id
     * @param CuentaId $cuenta_receptora_id
     * @param Amount $monto
     * @param Date $fecha
     * @param string $descripcion
     * @return self
     */
    public static function create(
         TransferenciaId $id,
         CuentaId $cuenta_enviadora_id,
         CuentaId $cuenta_receptora_id,
         Amount $monto,
         Date $fecha,
         string $descripcion

    ){
        $transferencia = new self(
           id: $id,
            cuenta_enviadora_id: $cuenta_enviadora_id,
            cuenta_receptora_id:  $cuenta_receptora_id,
           monto:  $monto,
           fecha:  $fecha,
           descripcion:  $descripcion
        );
        $transferencia->recordThat(new TransferenciaCreated($transferencia));
        return $transferencia;
    }

    /**
     * Reconstituye una transferencia existente
     * @param TransferenciaId $id
     * @param CuentaId $cuenta_enviadora_id
     * @param CuentaId $cuenta_receptora_id
     * @param Amount $monto
     * @param Date $fecha
     * @param string $descripcion
     * @return self
     */
    public static function reconstitute(
        TransferenciaId $id,
        CuentaId $cuenta_enviadora_id,
        CuentaId $cuenta_receptora_id,
        Amount $monto,
        Date $fecha,
        string $descripcion

    ){
        return new self(
            id: $id,
            cuenta_enviadora_id: $cuenta_enviadora_id,
            cuenta_receptora_id:  $cuenta_receptora_id,
            monto:  $monto,
            fecha:  $fecha,
            descripcion:  $descripcion
        );
    }

    public function getId(): AggregateModelIdContract
    {
        return $this->id;
    }

    /**
     * @return CuentaId
     */
    public function getCuentaEnviadoraId(): CuentaId
    {
        return $this->cuenta_enviadora_id;
    }

    /**
     * @return CuentaId
     */
    public function getCuentaReceptoraId(): CuentaId
    {
        return $this->cuenta_receptora_id;
    }

    /**
     * @return string
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }
    public function getFecha(): Date
    {
        return $this->fecha;
    }

    /**
     * @return Amount
     */
    public function getMonto(): Amount
    {
        return $this->monto;
    }
}
