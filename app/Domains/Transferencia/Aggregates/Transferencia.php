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
use App\Domains\Transferencia\Events\TransferenciaCreated;
use App\Domains\Transferencia\ValueObjects\TransferenciaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Transferencia\Exception\CannotCreateTransferenciaException;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Agregado de dominio de una transferencia
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 */
final  class Transferencia implements AggregateModelContract
{
    use \App\Shared\Domain\Traits\RecordsEvents;
    public function __construct(
        private TransferenciaId $id,
        private CuentaId $cuenta_origen_id,
        private CuentaId $cuenta_destino_id,
        private Amount $monto,
        private Date $fecha,
        private ?string $descripcion
    )
    {
    }

    /**
     * Crea una nueva transferencia
     * @param TransferenciaId $id
     * @param CuentaId $cuenta_origen_id
     * @param CuentaId $cuenta_destino_id
     * @param Amount $monto
     * @param Date $fecha
     * @param string $descripcion
     * @return self
     */
    public static function create(
         TransferenciaId $id,
         CuentaId $cuenta_origen_id,
         CuentaId $cuenta_destino_id,
         Amount $monto,
         Date $fecha,
         ?string $descripcion

    ){
        self::validateData($monto, $fecha, $descripcion);
        $transferencia = new self(
           id: $id,
            cuenta_origen_id: $cuenta_origen_id,
            cuenta_destino_id:  $cuenta_destino_id,
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
     * @param CuentaId $cuenta_origen_id
     * @param CuentaId $cuenta_destino_id
     * @param Amount $monto
     * @param Date $fecha
     * @param string $descripcion
     * @return self
     */
    public static function reconstitute(
        TransferenciaId $id,
        CuentaId $cuenta_origen_id,
        CuentaId $cuenta_destino_id,
        Amount $monto,
        Date $fecha,
        ?string $descripcion

    ){
        return new self(
            id: $id,
            cuenta_origen_id: $cuenta_origen_id,
            cuenta_destino_id:  $cuenta_destino_id,
            monto:  $monto,
            fecha:  $fecha,
            descripcion:  $descripcion
        );
    }

    private static function validateData(
        Amount $monto,
        Date $fecha,
        ?string $descripcion
    ){
        
        if ($monto->isLessOrEqualThanCero()) {
            throw new CannotCreateTransferenciaException('El monto debe ser mayor a cero.');
        }

        if ($fecha->getPeriod() > new \DateTimeImmutable()) {
            throw new CannotCreateTransferenciaException('La fecha no puede ser futura.');
        }
        if ($descripcion !== null && strlen($descripcion) > 255) {
            throw new CannotCreateTransferenciaException('La descripción no puede exceder los 255 caracteres.');
        }

    }
    public function getId(): AggregateModelIdContract
    {
        return $this->id;
    }

    /**
     * @return CuentaId
     */
    public function getCuentaOrigenId(): CuentaId
    {
        return $this->cuenta_origen_id;
    }

    /**
     * @return CuentaId
     */
    public function getCuentaDestinoId(): CuentaId
    {
        return $this->cuenta_destino_id;
    }

    /**
     * @return string
     */
    public function getDescripcion(): ?string
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
