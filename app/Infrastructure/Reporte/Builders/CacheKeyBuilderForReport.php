<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Builders;

use App\Domains\Reporte\ValueObjects\ReporteQuery;

final readonly class CacheKeyBuilderForReport{
   public static function build(string $prefix, ReporteQuery $dto): string
    {
        $payload = [
            'start_date' => $dto->dateRange->startDate->format('Y-m-d'),
            'end_date' => $dto->dateRange->endDate->format('Y-m-d'),
            'cuentas' => self::normalizeIds($dto->cuentas?->ids),
            'categorias' => self::normalizeIds($dto->categorias?->ids),
        ];

        $hash = hash('sha256', json_encode($payload, JSON_THROW_ON_ERROR));

        return sprintf(
            'reporte_%s_%s_%s_%s',
            $prefix,
            $dto->dateRange->startDate->format('Y-m-d'),
            $dto->dateRange->endDate->format('Y-m-d'),
            $hash
        );
    }

    private static function normalizeIds(?array $ids): string|array
    {
        if ($ids === null) {
            return 'all';
        }

        $ids = array_values(array_unique($ids));
        sort($ids);

        return empty($ids) ? 'none' : $ids;
    }
}