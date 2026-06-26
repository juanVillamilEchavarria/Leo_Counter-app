<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.1
 */
namespace App\Domains\Movimiento\Aggregates;
use App\Domains\Movimiento\Events\MovimientoDeleted;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\Events\MovimientoCreated;
use App\Domains\Movimiento\Exceptions\CannotExecuteMovimientoTransactionException;
use App\Domains\Movimiento\Exceptions\CannotUpdateMovimientoException;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\Contracts\PrimitiveAggregateModelContract;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use Throwable;
use App\Shared\Domain\Traits\RecordsEvents;
/**
 * Agregado raíz del dominio Movimiento.
 * Representa un ingreso o gasto **ya realizado** en el sistema.
 * Es la fuente de verdad contable y no se modifica, solo se puede anular.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Aggregates
 * @since 1.0.0
 * @version 1.0.1
 */
final   class Movimiento implements PrimitiveAggregateModelContract
{
use RecordsEvents;
    private function __construct(
        private MovimientoId           $id,
        private string                 $nombre,
        private CuentaId               $cuenta_id,
        private CategoriaId            $categoria_id,
        private TipoMovimientoEnum                    $tipo_movimiento_id,
        private ?MovimientoPendienteId $movimiento_pendiente_id,
        private Amount                  $monto,
        private Date                    $fecha,
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
     * @param TipoMovimientoEnum $tipo_movimiento_id Tipo de movimiento (ingreso/gasto).
     * @param Amount $monto Monto del movimiento.
     * @param Date $fecha Fecha en que se realizó el movimiento.
     * @param string|null $descripcion Descripción opcional.
     * @param MovimientoPendienteId|null $movimiento_pendiente_id Movimiento pendiente de origen, si aplica.
     * @return self
     */
    public static function create(
        MovimientoId           $id,
        string                 $nombre,
        CuentaId               $cuenta_id,
        CategoriaId            $categoria_id,
        TipoMovimientoEnum                    $tipo_movimiento_id,
        Amount                  $monto,
        Date      $fecha,
        ?string                $descripcion = null,
        ?MovimientoPendienteId $movimiento_pendiente_id = null,
    ): self
    {
        self::validateData($nombre, $monto, CannotExecuteMovimientoTransactionException::class);


        $movimiento= new self(
            id: $id,
            nombre: $nombre,
            cuenta_id: $cuenta_id,
            categoria_id: $categoria_id,
            tipo_movimiento_id: $tipo_movimiento_id,
            movimiento_pendiente_id: $movimiento_pendiente_id,
            monto: $monto,
            fecha: $fecha,
            descripcion: $descripcion,


        );
        $movimiento->recordThat(new MovimientoCreated($movimiento));
        return $movimiento;
    }
    public function delete(): self{
        $copy = new self(
            id: $this->id,
            nombre: $this->nombre,
            cuenta_id: $this->cuenta_id,
            categoria_id: $this->categoria_id,
            tipo_movimiento_id: $this->tipo_movimiento_id,
            movimiento_pendiente_id: $this->movimiento_pendiente_id,
            monto: $this->monto,
            fecha: $this->fecha,
            descripcion: $this->descripcion,
        );
        $copy->recordThat(new MovimientoDeleted($copy));
        return $copy;
    }

    /**
     * Reconstituye un movimiento desde la persistencia sin ejecutar validaciones.
     *
     * @param MovimientoId $id Identidad persistida.
     * @param string $nombre Nombre persistido.
     * @param CuentaId $cuenta_id Cuenta persistida.
     * @param CategoriaId $categoria_id Categoría persistida.
     * @param TipoMovimientoEnum $tipo_movimiento_id Tipo de movimiento persistido.
     * @param Amount $monto Monto persistido.
     * @param Date $fecha Fecha persistida.
     * @param string|null $descripcion Descripción persistida.
     * @param MovimientoPendienteId|null $movimiento_pendiente_id Movimiento pendiente de origen persistido.
     * @return self
     */
    public static function reconstitute(
        MovimientoId           $id,
        string                 $nombre,
        CuentaId               $cuenta_id,
        CategoriaId            $categoria_id,
        TipoMovimientoEnum                    $tipo_movimiento_id,
        Amount                  $monto,
        Date                    $fecha,
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
            movimiento_pendiente_id: $movimiento_pendiente_id,
            monto: $monto,
            fecha: $fecha,
            descripcion: $descripcion

        );
    }

    /**
     * Actualiza los datos de un movimiento.
     *
     * @param string $nombre Nuevo nombre.
     * @param CuentaId $cuenta_id Nueva cuenta.
     * @param CategoriaId $categoria_id Nueva categoría.
     * @param TipoMovimientoEnum $tipo_movimiento_id Nuevo tipo de movimiento.
     * @param Amount $monto Nuevo monto.
     * @param Date $fecha Nueva fecha.
     * @param string|null $descripcion Nueva descripción.
     * @return self
     * @throws  CannotUpdateMovimientoException
     */
    public function updateData(
        string            $nombre,
        CuentaId          $cuenta_id,
        CategoriaId       $categoria_id,
        TipoMovimientoEnum               $tipo_movimiento_id,
        Amount             $monto,
        Date $fecha,
        ?string           $descripcion = null,
    ): self
    {
        self::validateData($nombre, $monto, CannotUpdateMovimientoException::class);

        return new self(
            id: $this->id,
            nombre: $nombre,
            cuenta_id: $cuenta_id,
            categoria_id: $categoria_id,
            tipo_movimiento_id: $tipo_movimiento_id,
            movimiento_pendiente_id: $this->movimiento_pendiente_id,
            monto: $monto,
            fecha: $fecha,
            descripcion: $descripcion,

        );
    }


    /**
     * Valida los datos obligatorios del movimiento.
     *
     * @param class-string<Throwable> $exceptionClass Excepción específica del caso de uso.
     * @throws
     */
    private static function validateData(
        string $nombre,
        Amount  $monto,
        string $exceptionClass,
    ): void
    {
        if (trim($nombre) === '') {
            throw new $exceptionClass('El nombre del movimiento es obligatorio.');
        }

        if ($monto->isLessOrEqualThanCero()) {
            throw new $exceptionClass('El monto del movimiento no puede ser cero o negativo.');
        }
    }

    public function toPrimitive(): array
    {
        return [
            'id' => $this->id->getValue(),
            'nombre'=> $this->nombre,
            'cuenta_id' => $this->cuenta_id->getValue(),
            'categoria_id' => $this->categoria_id->getValue(),
            'tipo_movimiento_id' => $this->tipo_movimiento_id->value,
            'movimiento_pendiente_id' => $this->movimiento_pendiente_id?->getValue(),
            'monto' => $this->monto->getValue(),
            'fecha' => $this->fecha->format(),
            'descripcion' => $this->descripcion

        ];
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

    public function getTipoMovimientoId(): TipoMovimientoEnum
    {
        return $this->tipo_movimiento_id;
    }

    public function getMovimientoPendienteId(): ?MovimientoPendienteId
    {
        return $this->movimiento_pendiente_id;
    }

    public function getMonto(): Amount
    {
        return $this->monto;
    }

    public function getFecha(): Date
    {
        return $this->fecha;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }
}
