<?php

namespace App\Domains\MovimientoFijo\Aggregates;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoFijo\Exceptions\CannotStoreMovimientoFijoException;
use App\Domains\MovimientoFijo\Exceptions\CannotUpdateMovimientoFijoException;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Agregado raiz del dominio MovimientoFijo.
 * Representa una obligacion o ingreso recurrente configurado por el usuario, con sus relaciones
 * de categoria, cuenta, tipo de movimiento y frecuencia, ademas de los datos de programacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoFijo\Aggregates
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoFijo implements AggregateModelContract
{
    private function __construct(
        private MovimientoFijoId $id,
        private CategoriaId $categoria_id,
        private CuentaId $cuenta_id,
        private int $tipo_movimiento_id,
        private int $frecuencia_movimiento_id,
        private string $nombre,
        private float $monto,
        private Date $fecha_proximo,
        private ?int $dias_aviso,
        private ?string $descripcion,
        private bool $active,
        private bool $registrar_automatico,
    ) {
    }

    /**
     * Crea un nuevo movimiento fijo aplicando las invariantes del agregado.
     *
     * @param MovimientoFijoId $id Identidad del movimiento fijo.
     * @param CategoriaId $categoria_id Identidad de la categoria asociada.
     * @param CuentaId $cuenta_id Identidad de la cuenta asociada.
     * @param int $tipo_movimiento_id Identificador del tipo de movimiento.
     * @param int $frecuencia_movimiento_id Identificador de la frecuencia.
     * @param string $nombre Nombre descriptivo del movimiento fijo.
     * @param float $monto Monto programado del movimiento fijo.
     * @param Date $fecha_proximo Fecha del proximo registro.
     * @param int|null $dias_aviso Dias de aviso configurados.
     * @param string|null $descripcion Descripcion opcional.
     * @return self
     */
    public static function create(
        MovimientoFijoId $id,
        CategoriaId $categoria_id,
        CuentaId $cuenta_id,
        int $tipo_movimiento_id,
        int $frecuencia_movimiento_id,
        string $nombre,
        float $monto,
        Date $fecha_proximo,
        ?int $dias_aviso,
        ?string $descripcion,
    ): self {
        self::validateData($nombre, $monto, $tipo_movimiento_id, $frecuencia_movimiento_id, $dias_aviso, CannotStoreMovimientoFijoException::class);

        return new self(
            id: $id,
            categoria_id: $categoria_id,
            cuenta_id: $cuenta_id,
            tipo_movimiento_id: $tipo_movimiento_id,
            frecuencia_movimiento_id: $frecuencia_movimiento_id,
            nombre: $nombre,
            monto: $monto,
            fecha_proximo: $fecha_proximo,
            dias_aviso: $dias_aviso,
            descripcion: $descripcion,
            active: true,
            registrar_automatico: false,
        );
    }

    /**
     * Reconstituye un movimiento fijo desde persistencia sin ejecutar validaciones de creacion.
     *
     * @param MovimientoFijoId $id Identidad persistida.
     * @param CategoriaId $categoria_id Identidad de categoria persistida.
     * @param CuentaId $cuenta_id Identidad de cuenta persistida.
     * @param int $tipo_movimiento_id Identificador de tipo persistido.
     * @param int $frecuencia_movimiento_id Identificador de frecuencia persistido.
     * @param string $nombre Nombre persistido.
     * @param float $monto Monto persistido.
     * @param Date $fecha_proximo Fecha persistida.
     * @param int|null $dias_aviso Dias de aviso persistidos.
     * @param string|null $descripcion Descripcion persistida.
     * @param bool $active Estado persistido.
     * @param bool $registrar_automatico Estado de registro automatico persistido.
     * @return self
     */
    public static function reconstitute(
        MovimientoFijoId $id,
        CategoriaId $categoria_id,
        CuentaId $cuenta_id,
        int $tipo_movimiento_id,
        int $frecuencia_movimiento_id,
        string $nombre,
        float $monto,
        Date $fecha_proximo,
        ?int $dias_aviso,
        ?string $descripcion,
        bool $active,
        bool $registrar_automatico,
    ): self {
        return new self(
            id: $id,
            categoria_id: $categoria_id,
            cuenta_id: $cuenta_id,
            tipo_movimiento_id: $tipo_movimiento_id,
            frecuencia_movimiento_id: $frecuencia_movimiento_id,
            nombre: $nombre,
            monto: $monto,
            fecha_proximo: $fecha_proximo,
            dias_aviso: $dias_aviso,
            descripcion: $descripcion,
            active: $active,
            registrar_automatico: $registrar_automatico,
        );
    }

    /**
     * Actualiza los datos editables del movimiento fijo y preserva sus estados operativos.
     *
     * @param CategoriaId $categoria_id Nueva categoria asociada.
     * @param CuentaId $cuenta_id Nueva cuenta asociada.
     * @param int $tipo_movimiento_id Nuevo tipo de movimiento.
     * @param int $frecuencia_movimiento_id Nueva frecuencia.
     * @param string $nombre Nuevo nombre.
     * @param float $monto Nuevo monto.
     * @param Date $fecha_proximo Nueva fecha del proximo registro.
     * @param int|null $dias_aviso Nuevos dias de aviso.
     * @param string|null $descripcion Nueva descripcion.
     * @return self
     */
    public function updateData(
        CategoriaId $categoria_id,
        CuentaId $cuenta_id,
        int $tipo_movimiento_id,
        int $frecuencia_movimiento_id,
        string $nombre,
        float $monto,
        Date $fecha_proximo,
        ?int $dias_aviso,
        ?string $descripcion,
    ): self {
        self::validateData($nombre, $monto, $tipo_movimiento_id, $frecuencia_movimiento_id, $dias_aviso, CannotUpdateMovimientoFijoException::class);

        return new self(
            id: $this->id,
            categoria_id: $categoria_id,
            cuenta_id: $cuenta_id,
            tipo_movimiento_id: $tipo_movimiento_id,
            frecuencia_movimiento_id: $frecuencia_movimiento_id,
            nombre: $nombre,
            monto: $monto,
            fecha_proximo: $fecha_proximo,
            dias_aviso: $dias_aviso,
            descripcion: $descripcion,
            active: $this->active,
            registrar_automatico: $this->registrar_automatico,
        );
    }

    /**
     * Valida los datos esenciales del movimiento fijo antes de crear o actualizar.
     *
     * @param class-string<\Throwable> $exceptionClass Excepcion especifica del caso de uso.
     */
    private static function validateData(
        string $nombre,
        float $monto,
        int $tipo_movimiento_id,
        int $frecuencia_movimiento_id,
        ?int $dias_aviso,
        string $exceptionClass,
    ): void {
        if (trim($nombre) === '') {
            throw new $exceptionClass('El nombre del movimiento fijo es obligatorio.');
        }

        if ($monto < 0) {
            throw new $exceptionClass('El monto del movimiento fijo no puede ser negativo.');
        }

        if ($tipo_movimiento_id <= 0) {
            throw new $exceptionClass('El tipo de movimiento es obligatorio.');
        }

        if ($frecuencia_movimiento_id <= 0) {
            throw new $exceptionClass('La frecuencia del movimiento es obligatoria.');
        }

        if ($dias_aviso !== null && $dias_aviso < 0) {
            throw new $exceptionClass('Los dias de aviso no pueden ser negativos.');
        }
    }

    public function getId(): MovimientoFijoId
    {
        return $this->id;
    }

    public function getCategoriaId(): CategoriaId
    {
        return $this->categoria_id;
    }

    public function getCuentaId(): CuentaId
    {
        return $this->cuenta_id;
    }

    public function getTipoMovimientoId(): int
    {
        return $this->tipo_movimiento_id;
    }

    public function getFrecuenciaMovimientoId(): int
    {
        return $this->frecuencia_movimiento_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getMonto(): float
    {
        return $this->monto;
    }

    public function getFechaProximo(): Date
    {
        return $this->fecha_proximo;
    }

    public function getDiasAviso(): ?int
    {
        return $this->dias_aviso;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function getRegistrarAutomatico(): bool
    {
        return $this->registrar_automatico;
    }
}
