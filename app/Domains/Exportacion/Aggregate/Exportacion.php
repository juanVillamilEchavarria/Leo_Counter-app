<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */
namespace App\Domains\Exportacion\Aggregate;

use App\Domains\Exportacion\Enums\ExportableTable;
use App\Domains\Exportacion\Enums\ExportFormat;
use App\Domains\Exportacion\ValueObjects\ExportacionId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\Exceptions\InvalidDomainArgumentException;
use Date;
use DateTimeImmutable;
use Override;

final readonly class Exportacion implements AggregateModelContract{

    private function __construct(
        private ExportacionId $id,
        private UsuarioId $userId,
        private ExportableTable $table,
        private ExportFormat $format,
        private int $recordsCount,
        private string $filename,
        private ?array $filters = null

    )
    {
    }

    public static function create(
        UsuarioId $userId,
        ExportableTable $table,
        ExportFormat $format,
        int $recordsCount,
        IdGeneratorContract $idGenerator,
        ?array $filters = null,
        ?string $filename = null,

    ): self {
        $id = ExportacionId::generate($idGenerator);
        self::validatedata($recordsCount);
        return new self(
            id: $id,
            userId: $userId,
            table: $table,
            format: $format,
            recordsCount: $recordsCount,
            filters: $filters,
            filename: $filename ?? self::generateDefaultFilename($table, $format, $id)
        );
    }

    public static function reconstitute(
        ExportacionId $id,
        UsuarioId $userId,
        ExportableTable $table,
        ExportFormat $format,
        int $recordsCount,
        string $filename,
        ?array $filters = null
    ): self {
        return new self(
            id: $id,
            userId: $userId,
            table: $table,
            format: $format,
            recordsCount: $recordsCount,
            filters: $filters,
            filename: $filename
        );
    }

    private static function validatedata( int $recordsCount ): void{
        if($recordsCount <= 0){
            throw new InvalidDomainArgumentException('El número de registros debe ser mayor a 0');
        }
    }

    private static function generateDefaultFilename( ExportableTable $table, ExportFormat $format, ExportacionId $id ): string{
        $timestamp = new DateTimeImmutable();
        return sprintf(
            '%s_%s_%s.%s',
            $table->value,
            $timestamp->format('Ymd_His'),
            $id->getValue(),
            $format->value
        );
    }

    public function tooManyRecords(): bool{
        return $this->recordsCount >= 1000;
    }

    #[Override]
    public function getId(): AggregateModelIdContract
    {
        return $this->id;
    }

    public function getUserId(): UsuarioId
    {
        return $this->userId;
    }
    public function getTable(): ExportableTable
    {
        return $this->table;
    }
    public function getFormat(): ExportFormat{
        
        return $this->format;
    }

    public function getRecordsCount(): int
    {
        return $this->recordsCount;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getFilters(): ?array
    {
        return $this->filters;
    }


}