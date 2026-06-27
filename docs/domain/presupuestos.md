# Dominio: Presupuesto

## Propósito del Módulo

El módulo `Presupuesto` permite al usuario establecer **límites de gasto por categoría en un período mensual específico**. La UI lo presenta en dos vistas: los presupuestos del **mes actual** (con CRUD completo) y los **históricos** (solo lectura).

---

## Agregado Raíz: `Presupuesto`

**Namespace:** `App\Domains\Presupuesto\Aggregates\Presupuesto`

```php
final readonly class Presupuesto implements PrimitiveAggregateModelContract
{
    private function __construct(
        private PresupuestoId $id,
        private CategoriaId   $categoria_id,
        private Amount        $monto,
        private Date          $periodo,
        private ?string       $descripcion,
        private UsuarioId     $user_id,
    ) {}
}
```

---

## Métodos de Fábrica

| Método | Propósito | Valida unicidad |
|--------|-----------|----------------|
| `create(...)` | Crea un presupuesto nuevo | ✅ Via `PresupuestoUniquenessCheckerContract` |
| `reconstitute(...)` | Rehidrata desde persistencia | ❌ |
| `updateData(...)` | Actualiza monto y categoría | ✅ (unicidad ignorando el propio ID) |
| `duplicate(id, checker)` | Duplica al mes siguiente | ✅ Via `PresupuestoCanDuplicateCheckerContract` |

---

## Value Objects

| VO | Clase | Descripción |
|----|-------|-------------|
| Identidad | `PresupuestoId` | UUID v7 |
| Categoría | `CategoriaId` | Qué categoría limita |
| Monto | `Amount` | Límite de gasto |
| Período | `Date` | Mes al que aplica (formato `YYYY-MM`) |
| Usuario | `UsuarioId` | Quién creó el presupuesto |

---

## Reglas de Negocio (Invariantes)

### Unicidad

La combinación `(categoria_id, periodo)` es **única a nivel de base de datos** y también se valida en el dominio:

```php
public static function create(
    PresupuestoId $id,
    CategoriaId   $categoria_id,
    Amount        $monto,
    Date          $periodo,
    ?string       $descripcion,
    UsuarioId     $user_id,
    PresupuestoUniquenessCheckerContract $checker
): self {
    if (!$checker->isUnique($categoria_id, $periodo->format('Y-m'))) {
        throw new CannotStorePresupuestoException(
            'Ya existe un presupuesto para la fecha seleccionada'
        );
    }
    self::validateData($monto, CannotStorePresupuestoException::class);
    return new self(...);
}
```

### Duplicación

```php
public function duplicate(PresupuestoId $id, PresupuestoCanDuplicateCheckerContract $checker): self
{
    if (!$checker->canDuplicate($this->categoria_id, $this->periodo->format('Y-m'))) {
        throw new CannotStorePresupuestoException('Ya existe un presupuesto duplicado para este');
    }
    return new self(
        id: $id,
        categoria_id: $this->categoria_id,
        monto: $this->monto,
        periodo: $this->periodo->addMonths(), // Avanza al mes siguiente
        // ...
    );
}
```

**Invariantes:**
1. **Monto menor a cero**: `$monto->isLessOrEqualThanCero()` lanza excepción.
2. **Unicidad por categoría y período**: no pueden existir dos presupuestos para la misma categoría en el mismo mes.
3. **La duplicación** avanza el período al mes siguiente y verifica que no exista ya un presupuesto para ese nuevo período.
4. **Soft delete**: se puede enviar a la papelera y restaurar.

---

## Contratos de Dominio

| Contrato | Propósito |
|----------|-----------|
| `PresupuestoRepositoryContract` | CRUD del agregado |
| `PresupuestoUniquenessCheckerContract` | Verifica unicidad `(categoria_id, periodo)` |
| `PresupuestoCanDuplicateCheckerContract` | Verifica que se puede duplicar al mes siguiente |

---

## Esquema de Base de Datos

Tabla: `presupuestos`

| Columna | Tipo | Nulo | Descripción |
|---------|------|------|-------------|
| `id` | UUID (PK) | No | UUID v7 |
| `categoria_id` | UUID (FK → categorias) | No | Categoría presupuestada |
| `periodo` | date | No | Mes del presupuesto (`YYYY-MM-01`) |
| `monto` | decimal(18,2) | No | Límite de gasto |
| `user_id` | UUID (FK → users) | Sí | Usuario creador |
| `descripcion` | text | Sí | Nota opcional |
| `deleted_at` | timestamp | Sí | Soft delete |
| `created_at` / `updated_at` | timestamps | — | Auditoría técnica |

**Restricción única:** `presupuestos_categoria_fecha_unique`: `(categoria_id, periodo)`

**Índices:** `(categoria_id)`, `(user_id)`, `presupuestos_categoria_fecha_index`: `(categoria_id, periodo)`
