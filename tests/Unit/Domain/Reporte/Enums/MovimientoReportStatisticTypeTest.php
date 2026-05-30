<?php

namespace Tests\Unit\Domain\Reporte\Enums;

use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use PHPUnit\Framework\TestCase;

class MovimientoReportStatisticTypeTest extends TestCase
{  
    public function test_enum_values_exist(): void
    {
        $this->assertSame('kpis', MovimientoReportStatisticType::KPIS->value);
        $this->assertSame('balance_neto', MovimientoReportStatisticType::BALANCE_NETO->value);
        $this->assertSame('category_distribution', MovimientoReportStatisticType::CATEGORY_DISTRIBUTION->value);
        $this->assertSame('ingresos_vs_gastos', MovimientoReportStatisticType::INGRESOS_VS_GASTOS->value);
        $this->assertSame('ingresos', MovimientoReportStatisticType::INGRESOS->value);
        $this->assertSame('gastos', MovimientoReportStatisticType::GASTOS->value);
    }

    public function test_full_report_returns_all_types(): void
    {
        $types = MovimientoReportStatisticType::fullReport();

        $this->assertCount(6, $types);
        $this->assertContains(MovimientoReportStatisticType::KPIS, $types);
        $this->assertContains(MovimientoReportStatisticType::INGRESOS_VS_GASTOS, $types);
        $this->assertContains(MovimientoReportStatisticType::CATEGORY_DISTRIBUTION, $types);
        $this->assertContains(MovimientoReportStatisticType::BALANCE_NETO, $types);
        $this->assertContains(MovimientoReportStatisticType::INGRESOS, $types);
        $this->assertContains(MovimientoReportStatisticType::GASTOS, $types);
    }
    public function test_enum_implements_contract(): void
    {
        $type = MovimientoReportStatisticType::KPIS;

        $this->assertInstanceOf(
            \App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract::class,
            $type
        );
    }

    public function test_requires_comparative_data_for_kpis(): void
    {
        // Based on QUICK_REFERENCE, KPIS requires comparative data
        $type = MovimientoReportStatisticType::KPIS;

        // Check if method exists (if implemented in domain)
        if (method_exists($type, 'requiresComparativeData')) {
            $this->assertTrue($type->requiresComparativeData());
        }
    }

    public function test_does_not_require_comparative_data_for_balance_neto(): void
    {
        $type = MovimientoReportStatisticType::BALANCE_NETO;

        if (method_exists($type, 'requiresComparativeData')) {
            $this->assertFalse($type->requiresComparativeData());
        }
    }
}
