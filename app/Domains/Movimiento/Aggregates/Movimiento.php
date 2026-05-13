<?php

namespace App\Domains\Movimiento\Aggregates;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\Exceptions\CannotExecuteMovimientoTransactionException;
use App\Domains\Movimiento\Exceptions\CannotUpdateMovimientoException;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use DateTimeImmutable;
use Throwable;

/**
 * Agregado raíz del dominio Movimiento.
 * Representa un ingreso o gasto **ya realizado** en el sistema.
 * Es la fuente de verdad contable y no se modifica, solo se puede anular.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Aggregates
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class Movimiento implements AggregateModelContract
{
    private function __construct(
        private MovimientoId           $id,
        private string                 $nombre,
        private CuentaId               $cuenta_id,
        private CategoriaId            $categoria_id,
        private int                    $tipo_movimiento_id,
        private ?MovimientoPendienteId $movimiento_pendiente_id,
        private float                  $monto,
        private DateTimeImmutable      $fecha,
        private ?string                $descripcion,
    )
    {
    }

    /**
     * Registra un nuevo movimiento (hecho contable) aplicando sus invariantes.
     *
     * @param MovimientoId $id Identidad del movimiento.
     * @param string $nombre Nombre descriptivo.
     * @param CuentaId $cuenta_id Cuenta afectada.
     * @param CategoriaId $categoria_id Categoría del movimiento.
     * @param int $tipo_movimiento_id Tipo de movimiento (ingreso/gasto).
     * @param float $monto Monto del movimiento.
     * @param DateTimeImmutable $fecha Fecha en que se realizó el movimiento.
     * @param string|null $descripcion Descripción opcional.
     * @param MovimientoPendienteId|null $movimiento_pendiente_id Movimiento pendiente de origen, si aplica.
     * @return self
     */
    public static function create(
        MovimientoId           $id,
        string                 $nombre,
        CuentaId               $cuenta_id,
        CategoriaId            $categoria_id,
        int                    $tipo_movimiento_id,
        float                  $monto,
        DateTimeImmutable      $fecha,
        ?string                $descripcion = null,
        ?MovimientoPendienteId $movimiento_pendiente_id = null,
    ): self
    {
        self::validateData($nombre, $monto, $tipo_movimiento_id, CannotExecuteMovimientoTransactionException::class);

        return new self(
            id: $id,
            nombre: $nombre,
            cuenta_id: $cuenta_id,
            categoria_id: $categoria_id,
            tipo_movimiento_id: $tipo_movimiento_id,
            monto: $monto,
            fecha: $fecha,
            descripcion: $descripcion,
            movimiento_pendiente_id: $movimiento_pendiente_id,
        );
    }

    /**
     * Reconstituye un movimiento desde la persistencia sin ejecutar validaciones.
     *
     * @param MovimientoId $id Identidad persistida.
     * @param string $nombre Nombre persistido.
     * @param CuentaId $cuenta_id Cuenta persistida.
     * @param CategoriaId $categoria_id Categoría persistida.
     * @param int $tipo_movimiento_id Tipo de movimiento persistido.
     * @param float $monto Monto persistido.
     * @param DateTimeImmutable $fecha Fecha persistida.
     * @param string|null $descripcion Descripción persistida.
     * @param MovimientoPendienteId|null $movimiento_pendiente_id Movimiento pendiente de origen persistido.
     * @return self
     */
    public static function reconstitute(
        MovimientoId           $id,
        string                 $nombre,
        CuentaId               $cuenta_id,
        CategoriaId            $categoria_id,
        int                    $tipo_movimiento_id,
        float                  $monto,
        DateTimeImmutable      $fecha,
        ?string                $descripcion = null,
        ?MovimientoPendienteId $movimiento_pendiente_id = null,
    ): self
    {
        return new self(
            id: $id,
            nombre: $nombre,
            cuenta_id: $cuenta_id,
            categoria_id: $categoria_id,
            tipo_movimiento_id: $tipo_movimiento_id,
            monto: $monto,
            fecha: $fecha,
            descripcion: $descripcion,
            movimiento_pendiente_id: $movimiento_pendiente_id,
        );
    }

    /**
     * Actualiza los datos de un movimiento.
     *
     * @param string $nombre Nuevo nombre.
     * @param CuentaId $cuenta_id Nueva cuenta.
     * @param CategoriaId $categoria_id Nueva categoría.
     * @param int $tipo_movimiento_id Nuevo tipo de movimiento.
     * @param float $monto Nuevo monto.
     * @param DateTimeImmutable $fecha Nueva fecha.
     * @param string|null $descripcion Nueva descripción.
     * @return self
     */
    public function updateData(
        string            $nombre,
        CuentaId          $cuenta_id,
        CategoriaId       $categoria_id,
        int               $tipo_movimiento_id,
        float             $monto,
        DateTimeImmutable $fecha,
        ?string           $descripcion = null,
    ): self
    {
        self::validateData($nombre, $monto, $tipo_movimiento_id, CannotUpdateMovimientoException::class);

        return new self(
            id: $this->id,
            nombre: $nombre,
            cuenta_id: $cuenta_id,
            categoria_id: $categoria_id,
            tipo_movimiento_id: $tipo_movimiento_id,
            monto: $monto,
            fecha: $fecha,
            descripcion: $descripcion,
            movimiento_pendiente_id: $this->movimiento_pendiente_id,
        );
    }


    /**
     * Valida los datos obligatorios del movimiento.
     *
     * @param class-string<Throwable> $exceptionClass Excepción específica del caso de uso.
     */
    private static function validateData(
        string $nombre,
        float  $monto,
        int    $tipo_movimiento_id,
        string $exceptionClass,
    ): void
    {
        if (trim($nombre) === '') {
            throw new $exceptionClass('El nombre del movimiento es obligatorio.');
        }

        if ($monto < 0) {
            throw new $exceptionClass('El monto del movimiento no puede ser negativo.');
        }

        if ($tipo_movimiento_id <= 0) {
            throw new $exceptionClass('El tipo de movimiento es obligatorio.');
        }
    }

    // Getters
    public function getId(): MovimientoId
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getCuentaId(): CuentaId
    {
        return $this->cuenta_id;
    }

    public function getCategoriaId(): CategoriaId
    {
        return $this->categoria_id;
    }

    public function getTipoMovimientoId(): int
    {
        return $this->tipo_movimiento_id;
    }

    public function getMovimientoPendienteId(): ?MovimientoPendienteId
    {
        return $this->movimiento_pendiente_id;
    }

    public function getMonto(): float
    {
        return $this->monto;
    }

    public function getFecha(): DateTimeImmutable
    {
        return $this->fecha;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }
}
