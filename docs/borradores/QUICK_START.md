# Quick Start - Nuevas Funcionalidades de Reportes

## 🎯 Para el Usuario Final

### 1. Generar Reporte
1. Haz click en el botón **"Generar"** (botón verde en la esquina superior derecha)
2. Completa el formulario con tus filtros preferidos:
   - Categorías (ingresos/gastos)
   - Cuentas
   - Rango de fechas
3. Haz click en **"Generar Reporte"**
4. Los filtros se actualizan automáticamente en la sección "Filtros activos"

### 2. Restablecer Filtros
1. Localiza la sección "Filtros activos" (arriba de los gráficos)
2. Haz click en el botón **"Restablecer"** (con el icono de rotación)
3. Los filtros volverán a sus valores por defecto
4. Los datos del reporte se recargarán automáticamente

### 3. Ver Filtros Activos
La sección "Filtros activos" muestra:
- **Período**: Rango de fechas seleccionado (ej: "10 de marzo de 2026 - 18 de marzo de 2026")
- **Categorías**: Las categorías seleccionadas o "Todas las categorias"
- **Cuentas**: Las cuentas seleccionadas o "Todas las cuentas"

> 💡 Los filtros con múltiples valores son expandibles - haz click para ver la lista completa

---

## 🛠️ Para el Desarrollador

### Estructura de Carpetas
```
reportes/
├── hooks/
│   ├── Charts/
│   │   └── useActiveReportFilters.tsx    [Hook de estado de filtros]
│   ├── useResetActiveFilters.ts          [Hook de reset + refetch]
│   ├── useReporteApiData.tsx
│   └── ...
├── helpers/
│   ├── formatActiveFilters.ts             [Helper de formateo]
│   └── index.ts
├── components/
│   ├── Filters/
│   │   ├── ActiveReportFilters.tsx        [Componente de filtros + botón reset]
│   │   └── ...
│   ├── Sheet/
│   │   ├── ReporteSheetContent.tsx        [Auto-actualiza filtros]
│   │   └── ...
│   └── ...
├── IMPROVEMENTS.md                       [Documentación detallada]
└── ...
```

### Usar `useActiveReportFilters` en un componente

```tsx
import useActiveReportFilters from '@/app/domains/reportes/hooks/Charts/useActiveReportFilters'

export default function MiComponente() {
  const {
    periodo,
    setPeriodo,
    categorias,
    setCategorias,
    cuentas,
    setCuentas,
    reset
  } = useActiveReportFilters()

  return (
    <div>
      <p>Período: {periodo}</p>
      <button onClick={reset}>Resetear</button>
    </div>
  )
}
```

### Usar `useResetActiveFilters` en la página principal

```tsx
import useResetActiveFilters from '@/app/domains/reportes/hooks/useResetActiveFilters'

const { reset, isResetting } = useResetActiveFilters({
  setData,
  setIsLoading,
  setError,
  setActiveReportFilters
})

// Pasar a componente
<ActiveReportFilters
  periodo={periodo}
  categorias={categorias}
  cuentas={cuentas}
  onReset={reset}
  isResetting={isResetting}
/>
```

### Usar `formatActiveFilters` helper

```tsx
import { formatActiveFilters } from '@/app/domains/reportes/helpers'

const formData = { /* ... */ }
const { periodo, categorias, cuentas } = formatActiveFilters(formData)

// Output:
// {
//   periodo: "10 de marzo de 2026 - 18 de marzo de 2026",
//   categorias: ["Alimentación", "Transporte"],
//   cuentas: "Todas las cuentas"
// }
```

### Extender la Funcionalidad

#### Agregar un nuevo filtro
1. Actualiza `useActiveReportFilters`:
```tsx
const [nuevoFiltro, setNuevoFiltro] = useState('valor por defecto')

return {
  // ... existentes
  nuevoFiltro,
  setNuevoFiltro
}
```

2. Actualiza `formatActiveFilters`:
```tsx
export const formatActiveFilters = (formData: ReporteFormData) => {
  return {
    // ... existentes
    nuevoFiltro: formData.nuevoFiltro || 'Por defecto'
  }
}
```

3. Actualiza `ActiveReportFilters`:
```tsx
interface ActiveReportFiltersProps {
  // ... existentes
  nuevoFiltro: string
}

// En el JSX:
<li>
  <i className="fa-solid fa-icon"></i>
  <span>{nuevoFiltro}</span>
</li>
```

---

## 🔗 Flujo de Datos (Diagrama)

### Generación de Reporte
```
Usuario envía formulario
         ↓
ReporteForm (onSubmit)
         ↓
useGenerateReportMutation.mutate(formData)
         ↓
API request (generate-reporte)
         ↓
Éxito → setData(response)
       → updateActiveFilters()
           → formatActiveFilters(formData)
           → setPeriodo, setCategorias, setCuentas
```

### Reset de Filtros
```
Usuario hace click en botón "Restablecer"
         ↓
onReset callback ejecuta
         ↓
useResetActiveFilters.reset()
         ↓
setActiveReportFilters.reset() [vuelve a defaults]
         ↓
queryClient.invalidateQueries(['reporte'])
         ↓
queryClient.fetchQuery(['reporte'])
         ↓
setData(newData) → UI actualiza
```

---

## 🧪 Testing

### Test del Helper
```tsx
import { formatActiveFilters } from '@/app/domains/reportes/helpers'

test('formatActiveFilters debe formatear fechas correctamente', () => {
  const mockData = {
    startDate: '2026-03-10',
    endDate: '2026-03-18',
    categorias: [{ id: 1, nombre: 'Comida' }],
    cuentas: []
  }
  
  const result = formatActiveFilters(mockData)
  
  expect(result.periodo).toBe('10 de marzo de 2026 - 18 de marzo de 2026')
  expect(result.categorias).toEqual(['Comida'])
  expect(result.cuentas).toBe('Todas las cuentas')
})
```

### Test del Hook
```tsx
import { renderHook, act } from '@testing-library/react'
import useActiveReportFilters from '@/app/domains/reportes/hooks/Charts/useActiveReportFilters'

test('reset debe volver a valores por defecto', () => {
  const { result } = renderHook(() => useActiveReportFilters())
  
  act(() => {
    result.current.setPeriodo('Otro período')
  })
  
  act(() => {
    result.current.reset()
  })
  
  expect(result.current.periodo).toBe('Últimos 6 meses')
})
```

---

## 📚 Referencias

- Documentación completa: [`IMPROVEMENTS.md`](./IMPROVEMENTS.md)
- Resumen de cambios: [`REPORTES_REFACTOR_SUMMARY.md`](../../REPORTES_REFACTOR_SUMMARY.md)

---

## ❓ Preguntas Frecuentes

**P: ¿Qué pasa si el API falla durante el reset?**
R: El hook maneja automáticamente el error y lo pasa a `setError`. El UI mostrará el estado de error.

**P: ¿Cómo puedo agregar más filtros?**
R: Ver sección "Extender la Funcionalidad" arriba.

**P: ¿Se persisten los filtros al recargar la página?**
R: Actualmente no, pero está en las mejoras sugeridas. Puedes implementarlo usando localStorage.

**P: ¿Puedo usar estos hooks en otros módulos?**
R: Sí, los hooks están diseñados para ser reutilizables. Solo adapta `formatActiveFilters` según tu estructura de datos.

---

**¡Disfruta de la nueva interfaz mejorada!** 🚀
