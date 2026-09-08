<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Exportacion\Services;

use App\Application\Exportacion\Contracts\Services\ExportFileServiceContract;
use App\Application\Exportacion\DTOs\ExportDataResultDTO;
use App\Application\Exportacion\DTOs\GeneratedFileToExportDTO;
use App\Domains\Exportacion\Aggregate\Exportacion;
use App\Domains\Exportacion\Enums\ExportFormat;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\CSV\Writer as CsvWriter;
use OpenSpout\Writer\XLSX\Writer as XlsxWriter;
use Override;

/**
 * Servicio que genera el archivo de exportación (CSV o XLSX) usando OpenSpout
 * y lo envía al cliente por streaming, sin cargar el archivo completo en memoria.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class OpenSpoutExportFileService implements ExportFileServiceContract
{
    #[Override]
    public function stream(ExportDataResultDTO $data, Exportacion $export) : GeneratedFileToExportDTO
    {
            $writer = $export->getFormat() === ExportFormat::XLSX
                ? new XlsxWriter
                : new CsvWriter;

            
            $callable = function () use ($writer, $data) {
            $writer->openToFile('php://output');
            $writer->addRow(Row::fromValues($data->headers));

            foreach ($data->rows->getItems() as $row) {
                $writer->addRow(Row::fromValues(array_values($row)));
            }

            $writer->close();
        };

        return new GeneratedFileToExportDTO(
            streamCallback: $callable,
            filename: $export->getFilename(),
            format: $export->getFormat(),
        );     
        
    }
}
