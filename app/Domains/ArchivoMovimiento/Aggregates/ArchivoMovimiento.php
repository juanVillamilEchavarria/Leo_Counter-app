<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\ArchivoMovimiento\Aggregates;

use App\Domains\ArchivoMovimiento\Enums\ArchivoMovimientoDiskEnum;
use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;

final readonly class ArchivoMovimiento implements AggregateModelContract
{

    private function __construct(
        private ArchivoMovimientoId $id,
        private MovimientoId $movimiento_id,
        private string $nombre_original,
        private string $nombre_guardado,
        private ArchivoMovimientoDiskEnum $disk,
        private FilePath $path,
        private string $mime_type,
        private string $extension,
        private int $tamano_bytes,
        private ?string $notas

    )
    {
    }

    public static function create(
        ArchivoMovimientoId $id,
        MovimientoId $movimiento_id,
        string $nombre_original,
        ArchivoMovimientoDiskEnum $disk,
        FilePath $path,
        string $mime_type,
        string $extension,
        int $tamano_bytes,
        ?string $notas = null
    ): self{
        return new self(
            id: $id,
            movimiento_id: $movimiento_id,
            nombre_original: $nombre_original,
            nombre_guardado: $id->getValue() . '.'.$extension,
            disk: $disk,
            path: $path,
            mime_type: $mime_type,
            extension: $extension,
            tamano_bytes: $tamano_bytes,
            notas: $notas
        );
    }
    public  function updateData(
        MovimientoId $movimiento_id,
        string $nombre_original,
        ArchivoMovimientoDiskEnum $disk,
        FilePath $path,
        string $mime_type,
        string $extension,
        int $tamano_bytes,
        ?string $notas
    ): self{
        return new self(
            id: $this->id,
            movimiento_id: $movimiento_id,
            nombre_original: $nombre_original,
            nombre_guardado: $this->id->getValue() .'.'. $extension,
            disk: $disk,
            path: $path,
            mime_type: $mime_type,
            extension: $extension,
            tamano_bytes: $tamano_bytes,
            notas: $notas
        );
    }
    public static function reconstitute(
        ArchivoMovimientoId $id,
        MovimientoId $movimiento_id,
        string $nombre_original,
        ArchivoMovimientoDiskEnum $disk,
        FilePath $path,
        string $mime_type,
        string $extension,
        int $tamano_bytes,
        ?string $notas
    ): self{
        return new self(
            id: $id,
            movimiento_id: $movimiento_id,
            nombre_original: $nombre_original,
            nombre_guardado: $id->getValue() . '.'. $extension,
            disk: $disk,
            path: $path,
            mime_type: $mime_type,
            extension: $extension,
            tamano_bytes: $tamano_bytes,
            notas: $notas
        );
    }
    /**
     * Actualiza el path del archivo de movimiento.
     * @param FilePath $path
     * @return self
     */
    public function updatePath(
        FilePath $path
    ): self{
        return new self(
            id: $this->id,
            movimiento_id: $this->movimiento_id,
            nombre_original: $this->nombre_original,
            nombre_guardado: $this->id->getValue() .'.'. $this->extension,
            disk: $this->disk,
            path: $path,
            mime_type: $this->mime_type,
            extension: $this->extension,
            tamano_bytes: $this->tamano_bytes,
            notas: $this->notas
        );
    }


    public function getId(): AggregateModelIdContract
    {
        return $this->id;
    }

    public function getMovimientoId(): MovimientoId
    {
        return $this->movimiento_id;
    }

    public function getNombreOriginal(): string
    {
        return $this->nombre_original;
    }

    public function getNombreGuardado(): string
    {
        return $this->nombre_guardado;
    }

    public function getDisk(): ArchivoMovimientoDiskEnum
    {
        return $this->disk;
    }

    public function getPath(): FilePath
    {
        return $this->path;
    }

    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getTamanoBytes(): int
    {
        return $this->tamano_bytes;
    }

    public function getNotas(): ?string
    {
        return $this->notas;
    }
}
