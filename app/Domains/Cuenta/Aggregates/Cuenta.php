<?php

namespace App\Domains\Cuenta\Aggregates;

use App\Domains\Cuenta\Contracts\CuentaCanUpdateSaldoInicialCheckerContract;
use App\Shared\Domain\Contracts\AggregateModelContract;

/**
 * Entidad de modelo (agregado) Cuenta
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Cuenta\Aggregates
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class Cuenta implements AggregateModelContract
{
    /**
     * @param string $nombre - El nombre de la cuenta
     * @param ?string $notas - La descripción de la cuenta opcional
     * @param bool $active - Indica si la cuenta está activa
     * @param int $propietario_id - El ID del propietario de la cuenta
     * @param int $tipo_cuenta_id - El ID del tipo de cuenta
     */
    private function __construct(
        private string $nombre,
        private ?string $notas,
        private float $saldo_inicial,
        private float $saldo_actual,
        private bool $active,
        private int $propietario_id,
        private int $tipo_cuenta_id,
    ) {}

    /**
     * Crea una nueva cuenta
     * @param string $nombre
     * @param ?string $notas
     */
    public static function create(
        string $nombre,
        ?string $notas,
        float $saldo_inicial,
        int $propietario_id,
        int $tipo_cuenta_id
    ): self {

        return new self(
            nombre: $nombre,
            notas: $notas,
            saldo_inicial: $saldo_inicial,
            saldo_actual: $saldo_inicial,
            active: true,
            propietario_id: $propietario_id,
            tipo_cuenta_id: $tipo_cuenta_id,
        );
    }

    /**
     * Reconstituye (hidrata) una cuenta
     * @param string $nombre
     * @param ?string $notas
     * @param bool $active
     * @param int $propietario_id
     * @param int $tipo_cuenta_id
     */
    public static function reconstitute(
    
        string $nombre,
        ?string $notas,
        float $saldo_inicial,
        float $saldo_actual,
        bool $active,
        int $propietario_id,
        int $tipo_cuenta_id,
    ): self {
        return new self(
        
            nombre: $nombre,
            notas: $notas,
            saldo_inicial: $saldo_inicial,
            saldo_actual: $saldo_actual,
            active: $active,
            propietario_id: $propietario_id,
            tipo_cuenta_id: $tipo_cuenta_id,
        );
    }

    /**
     * Actualiza los datos de la cuenta
     * @param string $nombre
     * @param ?string $notas
     * @param int $tipo_cuenta_id
     * @param int $id
     * @param CuentaCanUpdateSaldoInicialCheckerContract $checker - Servicio que verifica si se puede actualizar el saldo de la cuenta
     */
    public function updateData(
        string $nombre,
        ?string $notas,
        float $saldo_inicial,
        float $saldo_actual,
        int $tipo_cuenta_id,
        int $id,
        CuentaCanUpdateSaldoInicialCheckerContract $checker,
    ): self {
        if ($checker->canUpdateSaldoInicial($id)) {
           $saldo_actual = $saldo_inicial;
        }

        return new self(
       
            nombre: $nombre,
            notas: $notas,
            saldo_inicial: $saldo_inicial,
            saldo_actual: $saldo_actual,
            active: $this->active,
            propietario_id: $this->propietario_id,
            tipo_cuenta_id: $tipo_cuenta_id,
        );
    }


    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getNotas(): ?string
    {
        return $this->notas;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function getPropietarioId(): int
    {
        return $this->propietario_id;
    }

    public function getTipoCuentaId(): int
    {
        return $this->tipo_cuenta_id;
    }
    public function getSaldoInicial(): float
    {
        return $this->saldo_inicial;
    }
    public function getSaldoActual(): float
    {
        return $this->saldo_actual;
    }
}