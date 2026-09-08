<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Contracts\Services;

use App\Application\Exportacion\DTOs\ExportDataResultDTO;
use App\Application\Exportacion\DTOs\GeneratedFileToExportDTO;
use App\Domains\Exportacion\Aggregate\Exportacion;
use App\Domains\Exportacion\Enums\ExportFormat;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Contrato del servicio que genera y envía el archivo de exportación por streaming.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
interface ExportFileServiceContract
{
    public function stream(ExportDataResultDTO $data, Exportacion $export): GeneratedFileToExportDTO;
}
