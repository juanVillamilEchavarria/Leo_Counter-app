<?php

namespace Tests\Unit\Domain\Reporte\ValueObjects;

use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use Tests\TestCase;

class ReporteQueryResultTest extends TestCase
{
    public function test_add_and_get_result(): void
    {
        $result = new ReporteQueryResult();
        $type = MovimientoReportStatisticType::KPIS;
        $data = ['ingresos' => 1000, 'gastos' => 500];

        $newResult = $result->add($type, $data);

        $this->assertNotSame($result, $newResult); // Inmutabilidad
        $this->assertTrue($newResult->has($type));
        $this->assertEquals($data, $newResult->get($type));
    }

    public function test_get_throws_exception_when_not_found(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $result = new ReporteQueryResult();
        $type = MovimientoReportStatisticType::KPIS;
        $result->get($type);
    }

    public function test_merge_combines_results(): void
    {
        $type1 = MovimientoReportStatisticType::KPIS;
        $type2 = MovimientoReportStatisticType::BALANCE_NETO;

        $result1 = (new ReporteQueryResult())->add($type1, ['data1']);
        $result2 = (new ReporteQueryResult())->add($type2, ['data2']);

        $merged = $result1->merge($result2);

        $this->assertTrue($merged->has($type1));
        $this->assertTrue($merged->has($type2));
    }

    public function test_add_previous_and_get_previous(): void
    {
        $type = MovimientoReportStatisticType::KPIS;
        $previousData = ['ingresos' => 800];

        $result = (new ReporteQueryResult())->addPrevious($type, $previousData);

        $this->assertTrue($result->hasPrevious($type));
        $this->assertEquals($previousData, $result->getPrevious($type));
    }

    public function test_get_previous_returns_null_for_non_existent_type(): void
    {
        $result = new ReporteQueryResult();
        $type = MovimientoReportStatisticType::KPIS;

        $this->assertNull($result->getPrevious($type));
    }

    public function test_has_previous_returns_false_for_non_existent_type(): void
    {
        $result = new ReporteQueryResult();
        $type = MovimientoReportStatisticType::KPIS;

        $this->assertFalse($result->hasPrevious($type));
    }

    public function test_merge_previous_results(): void
    {
        $type1 = MovimientoReportStatisticType::KPIS;
        $type2 = MovimientoReportStatisticType::BALANCE_NETO;

        $result1 = (new ReporteQueryResult())
            ->add($type1, ['main1'])
            ->addPrevious($type1, ['prev1']);

        $result2 = (new ReporteQueryResult())
            ->add($type2, ['main2'])
            ->addPrevious($type2, ['prev2']);

        $merged = $result1->merge($result2);

        // Main results
        $this->assertTrue($merged->has($type1));
        $this->assertTrue($merged->has($type2));
        $this->assertEquals(['main1'], $merged->get($type1));
        $this->assertEquals(['main2'], $merged->get($type2));

        // Previous results
        $this->assertTrue($merged->hasPrevious($type1));
        $this->assertTrue($merged->hasPrevious($type2));
        $this->assertEquals(['prev1'], $merged->getPrevious($type1));
        $this->assertEquals(['prev2'], $merged->getPrevious($type2));
    }

    public function test_merge_overwrites_existing_values(): void
    {
        $type = MovimientoReportStatisticType::KPIS;

        $result1 = (new ReporteQueryResult())->add($type, ['old']);
        $result2 = (new ReporteQueryResult())->add($type, ['new']);

        $merged = $result1->merge($result2);

        $this->assertEquals(['new'], $merged->get($type));
    }

    public function test_add_is_immutable(): void
    {
        $type = MovimientoReportStatisticType::KPIS;
        $original = new ReporteQueryResult();

        $modified = $original->add($type, ['data']);

        $this->assertNotSame($original, $modified);
        $this->assertFalse($original->has($type));
        $this->assertTrue($modified->has($type));
    }

    public function test_add_previous_is_immutable(): void
    {
        $type = MovimientoReportStatisticType::KPIS;
        $original = new ReporteQueryResult();

        $modified = $original->addPrevious($type, ['prev_data']);

        $this->assertNotSame($original, $modified);
        $this->assertFalse($original->hasPrevious($type));
        $this->assertTrue($modified->hasPrevious($type));
    }

    public function test_merge_is_immutable(): void
    {
        $type = MovimientoReportStatisticType::KPIS;
        $result1 = (new ReporteQueryResult())->add($type, ['data1']);
        $result2 = (new ReporteQueryResult())->add($type, ['data2']);

        $merged = $result1->merge($result2);

        $this->assertNotSame($result1, $merged);
        $this->assertEquals(['data1'], $result1->get($type));
        $this->assertEquals(['data2'], $merged->get($type));
    }
}