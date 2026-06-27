<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Cuenta\Aggregates;

use App\Domains\Cuenta\Contracts\CuentaCanUpdateSaldoInicialCheckerContract;
use App\Domains\Cuenta\Exceptions\CannotStoreCuentaException;
use App\Domains\Cuenta\Exceptions\CannotUpdateCuentaException;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Propietario\ValueObjects\PropietarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Amount;

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
     * @param PropietarioId $propietario_id - El ID del propietario de la cuenta
     * @param int $tipo_cuenta_id - El ID del tipo de cuenta
     */
    private function __construct(
        private CuentaId $id,
        private string   $nombre,
        private ?string  $notas,
        private Amount   $saldo_inicial,
        private Amount   $saldo_actual,
        private bool     $active,
        private PropietarioId   $propietario_id,
        private int      $tipo_cuenta_id,
    ) {}

    /**
     * Crea una nueva cuenta
     * @param string $nombre
     * @param ?string $notas
     */
    public static function create(
        CuentaId $id,
        string   $nombre,
        ?string  $notas,
        Amount   $saldo_inicial,
        PropietarioId   $propietario_id,
        int      $tipo_cuenta_id
    ): self {
        self::validateData($nombre, CannotStoreCuentaException::class);

        return new self(
            id: $id,
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
     * @param PropietarioId $propietario_id
     * @param int $tipo_cuenta_id
     */
    public static function reconstitute(
        CuentaId $id,
        string $nombre,
        ?string $notas,
        Amount $saldo_inicial,
        Amount $saldo_actual,
        bool $active,
        PropietarioId $propietario_id,
        int $tipo_cuenta_id,
    ): self {
        return new self(
            id: $id,
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
     * @param Amount $saldo_actual,
     * @param Amount $saldo_inicial,
     * @param int $tipo_cuenta_id
     * @param CuentaId $id
     * @param CuentaCanUpdateSaldoInicialCheckerContract $checker - Servicio que verifica si se puede actualizar el saldo de la cuenta
     */
    public function updateData(
        string $nombre,
        ?string $notas,
        Amount $saldo_inicial,
        Amount $saldo_actual,
        PropietarioId $propietario_id,
        int $tipo_cuenta_id,
        CuentaId $id,
        CuentaCanUpdateSaldoInicialCheckerContract $checker,
    ): self {
        if ($checker->canUpdateSaldoInicial($id)) {
           $saldo_actual = $saldo_inicial;
        }
        self::validateData($nombre, CannotUpdateCuentaException::class);

        return new self(
            id:$this->id,
            nombre: $nombre,
            notas: $notas,
            saldo_inicial: $saldo_inicial,
            saldo_actual: $saldo_actual,
            active: $this->active,
            propietario_id: $propietario_id,
            tipo_cuenta_id: $tipo_cuenta_id,
        );
    }

    /**
     * Actualiza el saldo actual de la cuenta
     * @param Amount $saldo_actual
     * @return self
     */
    public function updateSaldoActual(
        Amount $saldo_actual
    ): self{
        return new self(
            id:$this->id,
            nombre: $this->nombre,
            notas: $this->notas,
            saldo_inicial: $this->saldo_inicial,
            saldo_actual: $saldo_actual,
            active: $this->active,
            propietario_id: $this->propietario_id,
            tipo_cuenta_id: $this->tipo_cuenta_id,
        );
    }

    private static function validateData(
        string $nombre,
        string $exceptionClass,
    ): void
    {
        if (trim($nombre) === '') {
            throw new $exceptionClass('El nombre de la cuenta es obligatorio.');
        }
    }
    public function getId(): CuentaId
    {
        return $this->id;
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

    public function getPropietarioId(): PropietarioId
    {
        return $this->propietario_id;
    }

    public function getTipoCuentaId(): int
    {
        return $this->tipo_cuenta_id;
    }
    public function getSaldoInicial(): Amount
    {
        return $this->saldo_inicial;
    }
    public function getSaldoActual(): Amount
    {
        return $this->saldo_actual;
    }
}
