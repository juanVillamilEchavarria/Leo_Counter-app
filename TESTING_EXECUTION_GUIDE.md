# Guía de Ejecución de Tests

Este documento proporciona instrucciones detalladas para crear y ejecutar tests para el sistema de reportes.

---

## 1. CONFIGURACIÓN INICIAL

### 1.1 Instalación de dependencias de testing

Si no tienes Pest PHP instalado, ejecuta:

```bash
composer require pestphp/pest --dev
composer require mockery/mockery --dev
```

### 1.2 Verificar configuración

Asegúrate que tienes un archivo `tests/Pest.php`:

```bash
ls tests/Pest.php
```

Debería contener configuración base de Pest (helpers, expects, etc.).

### 1.3 Configuración de base de datos para tests

Crea o actualiza `.env.testing`:

```bash
cp .env .env.testing
```

Edita `.env.testing` para usar una BD de prueba (SQLite en memoria es lo más rápido):

```env
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

---

## 2. ESTRUCTURA DE DIRECTORIOS DE TESTS

```
tests/
├── Pest.php                          # Configuración base
├── TestCase.php                      # Clase base para tests
├── Unit/                             # Tests unitarios
│   ├── Domains/
│   │   ├── Reporte/
│   │   │   ├── ValueObjects/
│   │   │   │   ├── DateRangeTest.php
│   │   │   │   └── ReporteQueryResultTest.php
│   │   │   └── Enums/
│   │   │       └── Statistic/
│   │   │           └── MovimientoReportStatisticTypeTest.php
│   │   └── ...
│   ├── Application/
│   │   ├── Reporte/
│   │   │   ├── Mappers/
│   │   │   │   └── ReportQueryMapperTest.php
│   │   │   ├── Assemblers/
│   │   │   │   └── Movimientos/
│   │   │   │       └── KPIAssemblerTest.php
│   │   │   └── ...
│   │   └── ...
│   └── Shared/
│       └── Services/
│           └── Financial/
│               └── PercentageServiceTest.php
│
├── Feature/                          # Tests de integración
│   ├── Application/
│   │   └── Reporte/
│   │       ├── Handlers/
│   │       │   └── GenerateReportHandlerTest.php
│   │       └── ...
│   ├── Infrastructure/
│   │   └── Reporte/
│   │       └── Queries/
│   │           └── Handlers/
│   │               └── Movimientos/
│   │                   └── EloquentKPIsQueryExecutorTest.php
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/
│   │           └── Reporte/
│   │               └── ReporteApiControllerTest.php
│   └── Reporte/
│       └── ReporteGenerationFlowTest.php          # E2E
│
└── Fixtures/                         # Datos de prueba
    └── reporte_data.php
```

---

## 3. EJECUTAR TESTS

### 3.1 Ejecutar todos los tests

```bash
# Opción 1: Usando Pest
./vendor/bin/pest

# Opción 2: Usando Artisan
php artisan test
```

### 3.2 Ejecutar tests de un directorio específico

```bash
# Tests unitarios solamente
./vendor/bin/pest tests/Unit

# Tests de características solamente
./vendor/bin/pest tests/Feature

# Tests de un módulo específico
./vendor/bin/pest tests/Unit/Domains/Reporte

# Tests de un archivo específico
./vendor/bin/pest tests/Unit/Domains/Reporte/ValueObjects/DateRangeTest.php
```

### 3.3 Ejecutar un test específico

```bash
# Ejecutar un test específico por nombre
./vendor/bin/pest --filter="test_can_create_date_range_with_valid_dates"

# Ejecutar todos los tests que contengan "DateRange"
./vendor/bin/pest --filter="DateRange"

# Ejecutar todos los tests que contengan "handle"
./vendor/bin/pest --filter="handle"
```

### 3.4 Opciones útiles

```bash
# Mostrar salida detallada
./vendor/bin/pest -v

# Mostrar solo tests que fallaron
./vendor/bin/pest --failed

# Repetir últimos tests que fallaron
./vendor/bin/pest --rerun

# Parallel testing (múltiples procesos)
./vendor/bin/pest --parallel

# Con cobertura de código
./vendor/bin/pest --coverage

# Con cobertura HTML
./vendor/bin/pest --coverage --coverage-html=coverage
```

---

## 4. ESCRIBIR TESTS UNITARIOS

### 4.1 Estructura básica de test unitario

```php
<?php

namespace Tests\Unit\Domains\Reporte\ValueObjects;

use App\Domains\Reporte\ValueObjects\DateRange;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase
{
    public function test_can_create_date_range_with_valid_dates(): void
    {
        $startDate = new DateTimeImmutable('2024-01-01');
        $endDate = new DateTimeImmutable('2024-01-31');
        
        $dateRange = new DateRange($startDate, $endDate);
        
        $this->assertSame($startDate, $dateRange->startDate);
        $this->assertSame($endDate, $dateRange->endDate);
    }
    
    // Más tests...
}
```

### 4.2 Tipos de assertions útiles

```php
// Igualdad
$this->assertEquals($expected, $actual);
$this->assertSame($expected, $actual);  // Estricto
$this->assertNotEquals($expected, $actual);

// Tipo
$this->assertInstanceOf(MyClass::class, $object);
$this->assertTrue($boolean);
$this->assertFalse($boolean);

// Nulabilidad
$this->assertNull($value);
$this->assertNotNull($value);

// Arrays
$this->assertCount(5, $array);
$this->assertContains($item, $array);
$this->assertEmpty($array);

// Strings
$this->assertStringContains('expected', 'this string has expected text');
$this->assertStringStartsWith('prefix', 'prefix text');
$this->assertStringEndsWith('suffix', 'text suffix');

// Excepciones
$this->expectException(InvalidArgumentException::class);
```

---

## 5. ESCRIBIR TESTS DE INTEGRACIÓN

### 5.1 Estructura básica (con RefreshDatabase)

```php
<?php

namespace Tests\Feature\Http\Controllers\Api\Reporte;

use App\Models\User;
use Tests\TestCase;

class ReporteApiControllerTest extends TestCase
{
    use RefreshDatabase;  // Resetea la BD después de cada test
    
    public function test_index_returns_json_response(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->getJson('/api/reportes');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'KPIs',
                    'tendencia',
                    'distribuiciones',
                ]
            ]);
    }
}
```

### 5.2 Tipos de assertions para HTTP

```php
// Status
$response->assertStatus(200);
$response->assertOk();
$response->assertUnauthorized();
$response->assertForbidden();
$response->assertNotFound();

// JSON
$response->assertJson(['key' => 'value']);
$response->assertJsonStructure(['data' => ['id', 'name']]);
$response->assertJsonCount(5, 'data');
$response->assertJsonPath('data.id', 1);

// Validación
$response->assertJsonValidationErrors(['field1', 'field2']);
$response->assertJsonMissingValidationErrors(['field3']);

// Headers
$response->assertHeader('Content-Type', 'application/json');
$response->assertHeaderMissing('X-Custom-Header');
```

---

## 6. MOCKING Y STUBBING

### 6.1 Mockear dependencias

```php
<?php

use Mockery\MockInterface;

public function test_handler_calls_mapper(): void
{
    $mapperMock = $this->mock('App\Application\Reporte\Mappers\ReportQueryMapper');
    
    $mapperMock->shouldReceive('map')
        ->with($dto)
        ->once()
        ->andReturn($query);
    
    // Usar handler con mock...
}
```

### 6.2 Mockear modelos

```php
public function test_query_handler_with_mock_data(): void
{
    $mockKPI = Mockery::mock();
    $mockKPI->shouldReceive('totalIngresos')->andReturn(1000);
    $mockKPI->shouldReceive('totalGastos')->andReturn(500);
    $mockKPI->shouldReceive('totalBalance')->andReturn(500);
    $mockKPI->shouldReceive('totalMovimientos')->andReturn(10);
    
    // Usar mock...
}
```

### 6.3 Verificar que se llamó un método

```php
public function test_verifies_method_called(): void
{
    $mock = $this->mock(SomeClass::class);
    
    $mock->shouldReceive('method')->times(2);
    $mock->shouldReceive('other')->once();
    $mock->shouldReceive('never')->never();
    
    // Código que llama a los métodos...
    
    $mock->shouldHaveReceived('method');
}
```

---

## 7. FIXTURES Y FACTORIES

### 7.1 Usar factories para crear datos de prueba

```php
<?php

// En tests/Feature
use App\Models\Movimiento;
use App\Models\TipoMovimiento;

public function test_with_factory_data(): void
{
    $tipoMovimiento = TipoMovimiento::factory()->create();
    $movimientos = Movimiento::factory(10)->create([
        'tipo_movimiento_id' => $tipoMovimiento->id,
        'monto' => 1000,
    ]);
    
    // Ejecutar test...
}
```

### 7.2 Crear factories si no existen

```bash
php artisan make:factory TipoMovimientoFactory --model=TipoMovimiento
php artisan make:factory MovimientoFactory --model=Movimiento
```

Ejemplo de factory:

```php
<?php

namespace Database\Factories;

use App\Models\TipoMovimiento;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoMovimientoFactory extends Factory
{
    protected $model = TipoMovimiento::class;
    
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'tipo' => $this->faker->randomElement(['ingreso', 'gasto']),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
```

---

## 8. DATA PROVIDERS

### 8.1 Usar data providers para tests parametrizados

```php
<?php

/**
 * @dataProvider dateRangeProvider
 */
public function test_diff_days_with_various_ranges($days, $startDate, $endDate): void
{
    $dateRange = new DateRange(
        new DateTimeImmutable($startDate),
        new DateTimeImmutable($endDate)
    );
    
    $this->assertEquals($days, $dateRange->diffDays());
}

public static function dateRangeProvider(): array
{
    return [
        '1 day' => [1, '2024-01-01', '2024-01-02'],
        '30 days' => [30, '2024-01-01', '2024-01-31'],
        '365 days' => [365, '2024-01-01', '2025-01-01'],
    ];
}
```

### 8.2 Con Pest

```php
test('percentage calculation', function ($current, $previous, $expected) {
    $service = new PercentageService();
    
    $result = $service->calculatePercentageChange($current, $previous);
    
    expect($result)->toBe($expected);
})->with([
    [1000, 800, 25.0],
    [900, 1000, -10.0],
    [1000, 0, null],
]);
```

---

## 9. TESTING DE QUERIES ELOQUENT

### 9.1 Mock de QueryBuilder

```php
<?php

use Illuminate\Database\Eloquent\Builder;
use Mockery;

public function test_query_handler_with_mock_builder(): void
{
    $builderMock = Mockery::mock(Builder::class);
    
    $builderMock->shouldReceive('selectRaw')
        ->with(Mockery::any(), Mockery::any())
        ->andReturnSelf();
    
    $builderMock->shouldReceive('where')
        ->andReturnSelf();
    
    $builderMock->shouldReceive('groupByRaw')
        ->andReturnSelf();
    
    $builderMock->shouldReceive('get')
        ->andReturn(collect([]));
    
    // Test...
}
```

### 9.2 Testing real con BD de prueba

```php
<?php

class EloquentKPIsQueryExecutorTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_with_actual_database(): void
    {
        // Crear datos reales
        $tipoMovimiento = TipoMovimiento::factory()->create();
        Movimiento::factory()->create([
            'tipo_movimiento_id' => $tipoMovimiento->id,
            'monto' => 1000,
            'fecha' => '2024-01-15',
        ]);
        
        // Ejecutar handler
        $handler = app(EloquentKPIsQueryExecutor::class);
        $query = $this->createReporteQuery();
        
        $result = $handler->handle($query);
        
        // Assertions sobre resultado real
        $this->assertNotEmpty(iterator_to_array($result));
    }
}
```

---

## 10. OPTIMIZACIÓN Y PERFORMANCE

### 10.1 Evitar N+1 queries

```php
public function test_no_n_plus_one_queries(): void
{
    \DB::enableQueryLog();
    
    // Ejecutar código que pudiera tener N+1
    $results = // ... tu código
    
    $queryCount = count(\DB::getQueryLog());
    
    // Verificar que número de queries es razonable
    $this->assertLessThan(5, $queryCount);
}
```

### 10.2 Tests paralelos

```bash
# Ejecutar tests en paralelo (más rápido)
./vendor/bin/pest --parallel --processes=4
```

### 10.3 Fixtures reutilizables

```php
// En tests/TestCase.php
public function createStandardTestUser(): User
{
    return User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
}

public function createTestMovimientos(User $user, int $count = 10): Collection
{
    return Movimiento::factory($count)
        ->for($user)
        ->create();
}
```

---

## 11. COBERTURA DE CÓDIGO

### 11.1 Generar reporte de cobertura

```bash
# Cobertura en línea de comandos
./vendor/bin/pest --coverage

# Cobertura en HTML
./vendor/bin/pest --coverage --coverage-html=coverage

# Cobertura en texto
./vendor/bin/pest --coverage --coverage-text

# Con mínimo requerido
./vendor/bin/pest --coverage --coverage-text --coverage-min=80
```

### 11.2 Interpretar cobertura

```
Métrica       Significado
─────────────────────────────────
Line Coverage    % de líneas ejecutadas
Branch Coverage  % de branches (if/else) ejecutadas
Method Coverage  % de métodos ejecutados
```

---

## 12. DEBUGGING TESTS

### 12.1 Usar dd() para debuggear

```php
public function test_debug_example(): void
{
    $dateRange = DateRange::lastSixMonths();
    
    dd($dateRange);  // Detiene y muestra contenido
}
```

### 12.2 Usar dump() sin detener

```php
public function test_dump_example(): void
{
    $dateRange = DateRange::lastSixMonths();
    
    dump($dateRange);  // Muestra pero continúa
    
    $this->assertTrue(true);
}
```

### 12.3 Ejecutar en modo debug

```bash
# Con salida verbose
./vendor/bin/pest -v

# Con debug detallado
./vendor/bin/pest --debug

# Parar en primer error
./vendor/bin/pest -x
```

---

## 13. CI/CD INTEGRATION

### 13.1 GitHub Actions workflow

Crear `.github/workflows/tests.yml`:

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_DATABASE: leo_counter_test
          MYSQL_ROOT_PASSWORD: root
    
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.2
      
      - name: Install dependencies
        run: composer install
      
      - name: Run tests
        run: ./vendor/bin/pest --coverage
      
      - name: Upload coverage
        uses: codecov/codecov-action@v3
```

---

## 14. COMANDOS RÁPIDOS

```bash
# Crear test unitario
php artisan make:test Unit/Domains/Reporte/ValueObjects/DateRangeTest

# Crear test de feature
php artisan make:test Feature/Http/Controllers/ReporteControllerTest

# Ejecutar tests y parar en primer error
./vendor/bin/pest -x

# Listar todos los tests
./vendor/bin/pest --list

# Ejecutar últimos tests que fallaron
./vendor/bin/pest --rerun

# Solo tests de un grupo específico
./vendor/bin/pest --group=unit

# Con profiler
./vendor/bin/pest --profile
```

---

## 15. CHECKLIST ANTES DE HACER COMMIT

- [ ] Todos los tests unitarios pasan: `./vendor/bin/pest tests/Unit`
- [ ] Todos los tests de feature pasan: `./vendor/bin/pest tests/Feature`
- [ ] Cobertura de código >= 80%: `./vendor/bin/pest --coverage`
- [ ] No hay warnings ni notices: `./vendor/bin/pest -v`
- [ ] Tests E2E pasan: `./vendor/bin/pest tests/Feature/Reporte`
- [ ] No hay N+1 queries en tests de integración
- [ ] Código sigue los estándares del proyecto

---

## 16. REFERENCIAS Y RECURSOS

**Documentación oficial:**
- Pest PHP: https://pestphp.com
- Laravel Testing: https://laravel.com/docs/testing
- PHPUnit: https://phpunit.de

**Libros y tutoriales:**
- "Test Driven Development" by Kent Beck
- "Growing Object-Oriented Software, Guided by Tests"
- Laravel TestWorks (series de videos)

**Herramientas útiles:**
- Pest Debug Extension
- PHPStorm IDE (soporte nativo para tests)
- VS Code + Pest extension
