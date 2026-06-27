<?php
namespace Tests\Unit\Shared\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use App\Shared\Domain\ValueObjects\Amount;
use InvalidArgumentException;

final class AmountTest extends TestCase
{
    public function test_it_can_subtract_valid_amounts(): void
    {
        $montoInicial = new Amount(100);
        $montoARestar = new Amount(80);

        $resultado = $montoInicial->subtract($montoARestar);

        $this->assertEquals(20, $resultado->getValue());
    }

    public function test_it_can_add_valid_amounts(): void
    {
        $montoInicial = new Amount(50.50);
        $montoASumar = new Amount(49.50);

        $resultado = $montoInicial->add($montoASumar);

        $this->assertEquals(100, $resultado->getValue());
    }

    public function test_subtracting_more_than_available_throws_exception(): void
    {
        $montoInicial = new Amount(50);
        $montoARestar = new Amount(100);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El resultado no puede ser negativo');

        //  el test pasará si lanza la excepción
        $montoInicial->subtract($montoARestar);
    }
    
    public function test_cannot_create_negative_amount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El monto debe ser positivo');

        new Amount(-10);
    }
}