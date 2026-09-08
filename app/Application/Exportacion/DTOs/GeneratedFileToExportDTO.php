<?php

namespace App\Application\Exportacion\DTOs;

use App\Domains\Exportacion\Enums\ExportFormat;
use Closure;

final readonly class GeneratedFileToExportDTO
{
    public function __construct(
        public Closure $streamCallback,
        public string $filename,
        public ExportFormat $format,
    ) {
    }
    public function getMimeType(): string
    {
        return match($this->format) {
            ExportFormat::CSV => 'text/csv; charset=UTF-8',
            ExportFormat::XLSX => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        };
    }
}