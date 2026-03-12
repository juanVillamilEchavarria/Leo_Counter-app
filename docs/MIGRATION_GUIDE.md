# Guía de Migración - Sistema de Reportes (Inertia → API REST)

## 📋 Cambios Realizados

### ✅ Nuevos Archivos Creados

1. **`useReporteForm.tsx`** (Hook de gestión de estado)
   - Maneja estado del formulario sin Inertia
   - Auto-limpieza de errores al escribir
   - Tipado fuerte con TypeScript
   - Factory function para initial state (mejor testability)

2. **`useGenerateReportMutation.tsx`** (Hook de mutación API)
   - Integración con React Query para solicitudes asincrónicas
   - Parsing automático de errores de validación de Laravel
   - Callbacks para éxito y error
   - Separación de errores generales vs validación

3. **`hooks/index.ts`** (Punto de entrada de hooks)
   - Exportaciones centralizadas
   - Mejor experiencia de desarrollador (auto-complete)

4. **`docs/reportes_refactor.md`** (Documentación completa)
   - Explicación de cambios
   - Principios SOLID implementados
   - Ejemplos de uso
   - Próximos pasos recomendados

---

### 🔄 Archivos Modificados

#### **ReporteSheetContent.tsx**
```typescript
// ❌ ANTES
import useReporte from "../../hooks/useReporte"

export default function ReporteSheetContent() {
  const { form, handleSubmit } = useReporte({})
  return <ReporteForm {...form} options={options} submit={handleSubmit} />
}

// ✅ DESPUÉS
import { useReporteForm } from "../../hooks/useReporteForm"
import { useGenerateReportMutation } from "../../hooks/api/useGenerateReportMutation"

export default function ReporteSheetContent() {
  const form = useReporteForm()
  const { mutate, isPending, validationErrors } = useGenerateReportMutation(...)
  
  const handleSubmit = async (e) => {
    e.preventDefault()
    form.clearErrors()
    await mutate(form.data)
  }
  
  const mergedErrors = { ...form.errors, ...validationErrors }
  
  return (
    <ReporteForm
      data={form.data}
      setData={form.setData}
      errors={mergedErrors}
      onSubmit={handleSubmit}
      isLoading={isPending}
      options={options}
    />
  )
}
```

#### **ReporteForm.tsx**
```typescript
// ❌ ANTES
interface ReporteFormOptions {
  data: ReporteFormData
  setData: (key: string, value: any) => void
  errors: Record<string, string>
  submit: React.FormEventHandler<HTMLFormElement>
  processing: boolean
  options: ReporteFormOptionsApiReponse | undefined
}

export default function ReporteForm({
  data, setData, errors, submit, processing, options
}: ReporteFormOptions) {
  return (
    <form onSubmit={submit}>
      {/* Sin validación visual de errores */}
    </form>
  )
}

// ✅ DESPUÉS
interface ReporteFormProps {
  data: ReporteFormData
  setData: (key: keyof ReporteFormData, value: any) => void
  errors: Record<string, string>
  onSubmit: React.FormEventHandler<HTMLFormElement>
  isLoading?: boolean
  options: ReporteFormOptionsApiReponse | undefined
}

export default function ReporteForm({
  data, setData, errors, onSubmit, isLoading = false, options
}: ReporteFormProps) {
  return (
    <form onSubmit={onSubmit}>
      <div className="formulario-campo">
        <label htmlFor="startDate">Fecha de inicio</label>
        <InputFillable
          value={data.startDate}
          onChange={(e) => setData('startDate', e.target.value)}
          className={errors.startDate && 'border-red-500! text-red-500!'}
        />
        <TransitionMotion active={!!errors.startDate}>
          <AlertMessage message={errors.startDate} />
        </TransitionMotion>
      </div>
      {/* ... más campos con validación */}
    </form>
  )
}
```

---

## 🔌 Cómo Usar

### 1. En un Componente
```typescript
import { useReporteForm } from '@/app/domains/reportes/hooks'
import { useGenerateReportMutation } from '@/app/domains/reportes/hooks'

export function ReporteGenerator() {
  // Estado del formulario
  const form = useReporteForm({
    startDate: '2024-01-01' // Inicial opcional
  })

  // Mutación con errores
  const { mutate, isPending, validationErrors } = useGenerateReportMutation(
    // Success callback
    (reporteData) => {
      console.log('Reporte generado:', reporteData)
      // Redirigir a vista del reporte
    },
    // Error callback
    (fieldErrors) => {
      console.error('Errores:', fieldErrors)
      // Mostrar toast
    }
  )

  // Handler
  const handleSubmit = async (e) => {
    e.preventDefault()
    form.clearErrors()
    
    try {
      await mutate(form.data)
    } catch (err) {
      console.error('Error:', err)
    }
  }

  return (
    <form onSubmit={handleSubmit}>
      <input
        value={form.data.startDate}
        onChange={(e) => form.setData('startDate', e.target.value)}
      />
      {form.errors.startDate && <p>{form.errors.startDate}</p>}
    </form>
  )
}
```

### 2. Actualizar Endpoint Backend
```php
// routes/api.php
Route::post('/reportes/generate', [ReporteController::class, 'generate'])->name('api.reportes.generate');

// app/Http/Requests/GenerateReporteRequest.php
class GenerateReporteRequest extends FormRequest {
    public function rules(): array {
        return [
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date', 'after:startDate'],
            'cuentas' => ['required', 'array', 'min:1'],
            'cuentas.*' => ['integer', 'exists:cuentas,id'],
            'categorias' => ['array'],
            'categorias.*' => ['integer', 'exists:categorias,id'],
            'only_categorias_fijas' => ['boolean']
        ];
    }
}

// app/Http/Controllers/ReporteController.php
public function generate(GenerateReporteRequest $request) {
    return response()->json([
        'message' => 'Reporte generado exitosamente',
        'data' => [
            'id' => 123,
            'KPIs' => [...],
            // ... resto de datos del reporte
        ]
    ]);
}
```

---

## 🧪 Testing

### Test del Hook useReporteForm
```typescript
import { renderHook, act } from '@testing-library/react'
import { useReporteForm } from '@/domains/reportes/hooks'

describe('useReporteForm', () => {
  it('should initialize with default data', () => {
    const { result } = renderHook(() => useReporteForm())
    expect(result.current.data.startDate).toBe('')
    expect(result.current.data.cuentas).toEqual([])
  })

  it('should update data and clear error', () => {
    const { result } = renderHook(() => useReporteForm())
    
    act(() => {
      result.current.setErrors({ startDate: 'Error' })
    })
    
    expect(result.current.errors.startDate).toBe('Error')
    
    act(() => {
      result.current.setData('startDate', '2024-01-01')
    })
    
    expect(result.current.data.startDate).toBe('2024-01-01')
    expect(result.current.errors.startDate).toBeUndefined()
  })

  it('should reset form', () => {
    const { result } = renderHook(() => useReporteForm({
      startDate: '2024-01-01'
    }))
    
    act(() => {
      result.current.resetForm()
    })
    
    expect(result.current.data.startDate).toBe('')
    expect(result.current.errors).toEqual({})
  })
})
```

---

## 📊 Comparativa: Antes vs Después

| Característica | Antes (Inertia) | Después (API) |
|---|---|---|
| **Framework de Forms** | useForm de Inertia | Hook personalizado SOLID |
| **Request HTTP** | Inertia.post() | React Query mutation |
| **Errores Backend** | Dispersos en form.errors | Centralizados y parseados |
| **Tipado** | Débil (any en strings) | Fuerte con keyof |
| **Testabilidad** | Difícil (mock Inertia) | Fácil (funciones puras) |
| **Reutilización** | Solo en Inertia | En cualquier contexto |
| **DX** | Implícito/magic | Explícito/claro |
| **Bundle Size** | +Inertia | +React Query |
| **Performance** | Re-renders por Inertia | Optimizado con React Query |
| **Control** | Limitado | Total |

---

## ⚠️ Cambios que Requieren Atención

### 1. Props del Componente ReporteForm
```typescript
// ❌ NO USAR
<ReporteForm {...form} submit={handleSubmit} processing={false} />

// ✅ USAR
<ReporteForm
  data={form.data}
  setData={form.setData}
  errors={mergedErrors}
  onSubmit={handleSubmit}
  isLoading={isPending}
  options={options}
/>
```

### 2. Mapeo de Propiedades
```typescript
// ❌ Antes: solo_categorias_fijas
// ✅ Después: only_categorias_fijas

// ❌ Antes: fecha_inicio, fecha_fin
// ✅ Después: startDate, endDate
```

### 3. Manejo de Errores Dual
```typescript
// Los errores pueden venir de dos fuentes:
// 1. Form validation (cambios del usuario)
const formErrors = form.errors;

// 2. API validation (respuesta del servidor)
const apiErrors = validationErrors;

// Siempre fusionar ambos:
const allErrors = { ...formErrors, ...apiErrors };
```

---

## 📚 Referencias

- **Hooks creados**: `resources/js/app/domains/reportes/hooks/`
- **Componentes actualizados**: `resources/js/app/domains/reportes/components/Sheet/`
- **Documentación detallada**: `docs/reportes_refactor.md`
- **Patrón de validación consistente**: Ver `MovimientoPendienteForm.tsx`

---

## ✨ Beneficios Logrados

✅ **Desacoplamiento de Inertia** - Código reutilizable
✅ **Validaciones visuales claras** - UX mejorada
✅ **Errores centralizados** - Debugging más fácil
✅ **Código SOLID** - Mantenible y escalable
✅ **Testing facilitado** - Funciones puras
✅ **Type-safe** - Errores en compile-time
✅ **Consistencia** - Mismo patrón en toda la app

