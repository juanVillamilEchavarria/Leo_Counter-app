## Diagrama de Arquitectura - Sistema de Reportes

### 🏗️ Estructura de Capas

```
┌─────────────────────────────────────────────────────────────────┐
│                        UI LAYER                                 │
│                   (React Components)                            │
│                                                                 │
│              ┌──────────────────────────────────┐              │
│              │   ReporteSheetContent.tsx        │              │
│              │   (Orquestador Principal)        │              │
│              └──────────────────────────────────┘              │
│                         ↓ props                                │
│              ┌──────────────────────────────────┐              │
│              │   ReporteForm.tsx                │              │
│              │   (Formulario de Validación)     │              │
│              └──────────────────────────────────┘              │
└─────────────────────────────────────────────────────────────────┘
           ↓ hooks                          ↓ hooks
┌─────────────────────────────────────────────────────────────────┐
│                       HOOKS LAYER                               │
│                  (Business Logic)                               │
│                                                                 │
│  ┌────────────────────────┐    ┌────────────────────────────┐ │
│  │  useReporteForm.tsx    │    │useGenerateReportMutation.tsx
│  │                        │    │                            │ │
│  │ • Estado del formulario│    │ • React Query mutation     │ │
│  │ • Validación local     │    │ • Parsing de errores API   │ │
│  │ • Auto-limpieza errs   │    │ • Callbacks success/error  │ │
│  │ • Reset de forma       │    │ • Field-level errors       │ │
│  └────────────────────────┘    └────────────────────────────┘ │
│           ↓                                 ↓                  │
│        form.data                      mutation state           │
│        form.errors                    validationErrors         │
└─────────────────────────────────────────────────────────────────┘
           ↓ axios                      ↓ axios
┌─────────────────────────────────────────────────────────────────┐
│                      API LAYER                                  │
│                   (External Services)                           │
│                                                                 │
│              ┌──────────────────────────────────┐              │
│              │  generateReporteApi()            │              │
│              │  (Axios call to /api/reportes)  │              │
│              └──────────────────────────────────┘              │
└─────────────────────────────────────────────────────────────────┘
                       ↓ HTTP POST
                   ┌───────────────┐
                   │    Laravel    │
                   │  API Backend  │
                   └───────────────┘
```

---

### 🔄 Flujo de Datos (Happy Path)

```
Usuario escribe fecha
        ↓
form.setData('startDate', value)
        ↓
   setState actualiza
        ↓
   clearError('startDate')
        ↓
  componente re-render
        ↓
Usuario hace submit
        ↓
handleSubmit(e)
        ↓
form.clearErrors()
        ↓
mutate(form.data)
        ↓
generateReporteApi(data)
        ↓
POST /api/reportes/generate
        ↓
  Laravel valida
        ↓
  Retorna validData
        ↓
mutation.onSuccess()
        ↓
   onSuccess callback
        ↓
Mostrar reporte / Redirigir
```

---

### ❌ Flujo de Datos (Error Path)

```
Usuario hace submit con datos inválidos
        ↓
mutate(form.data)
        ↓
generateReporteApi(data)
        ↓
POST /api/reportes/generate
        ↓
  Laravel valida
        ↓
  422 Unprocessable Entity
        ↓
  {
    "message": "Validación fallida",
    "errors": {
      "startDate": ["La fecha es requerida"],
      "endDate": ["Debe ser posterior a startDate"]
    }
  }
        ↓
mutation.onError(axiosError)
        ↓
parseApiErrors(error) 
        ↓
validationErrors = {
  startDate: "La fecha es requerida",
  endDate: "Debe ser posterior a startDate"
}
        ↓
mergedErrors = { ...form.errors, ...validationErrors }
        ↓
Re-render con errores mostrados
        ↓
Usuario ve AlertMessage bajo cada campo
```

---

### 📦 Estructura de Carpetas

```
domains/reportes/
├── components/
│   ├── Sheet/
│   │   ├── ReporteSheet.tsx          (Componente shell)
│   │   ├── ReporteSheetContent.tsx   ✅ ACTUALIZADO (orquestador)
│   │   ├── ReporteForm.tsx           ✅ ACTUALIZADO (formulario)
│   │   └── ItemsSelectedListGroup.tsx (listado de items)
│   └── ...
├── hooks/
│   ├── index.ts                      ✅ NUEVO (exports)
│   ├── useReporteForm.tsx            ✅ NUEVO (estado local)
│   ├── useReporte.tsx                ❌ DEPRECATED (Inertia)
│   ├── useGenerateReporte.tsx        (wrapper simple)
│   ├── useReporteFormOptions.tsx     (forma alternativa)
│   └── api/
│       ├── useGenerateReportMutation.tsx ✅ NUEVO (mutation)
│       ├── useGenerateReporteApi.tsx     (query, obsoleto)
│       └── useReporteFormOptionsApi.tsx  (query)
├── api/
│   └── reporte.api.ts                (llamadas Axios)
├── types/
│   └── reporte.types.ts              (tipos TypeScript)
├── index.ts                          (exports públicos)
└── ...
```

---

### 🧩 Composición de Componentes

```
ReporteSheet
    ↓
ReporteSheetContent (hooks: useReporteForm, useGenerateReportMutation)
    ├── useReporteFormOptionsApi() → options
    ├── useReporteForm() → form
    ├── useGenerateReportMutation() → mutation
    │
    └── ReporteForm
        ├── props: data, setData, errors, onSubmit, isLoading, options
        │
        ├── SelectModel (Categorías Ingreso)
        ├── SelectModel (Categorías Gasto)
        ├── SelectModel (Cuentas)
        ├── InputFillable (Fecha Inicio)
        ├── InputFillable (Fecha Fin)
        │
        └── InputFillable + TransitionMotion + AlertMessage (repeats para cada field)
```

---

### 🔌 Inyección de Dependencias

```
                    ReporteSheetContent
                           |
                    (Dependencies)
                           |
        ┌──────────────────┼──────────────────┐
        ↓                  ↓                  ↓
   useReporteForm()  useReporteForm    useGenerateReportMutation()
   Options API       validation        
        |            
        ↓
  Axios/generateReporteApi
        |
        ↓
    Laravel API
```

---

### 🎯 Principios SOLID Implementados

```
ReporteForm.tsx
├── S: Single Responsibility
│   └─ Solo renderiza el formulario
├── O: Open/Closed
│   └─ Fácil agregar nuevos campos sin modificar código existente
├── L: Liskov Substitution
│   └─ Interfaz consistente con otros formularios
├── I: Interface Segregation
│   └─ Props mínimos necesarios
└── D: Dependency Inversion
    └─ Callbacks en lugar de acciones globales

useReporteForm.tsx
├── S: Single Responsibility
│   └─ Solo gestiona estado del formulario
├── O: Open/Closed
│   └─ Extensible sin modificaciones
├── L: Liskov Substitution
│   └─ Hook predecible y reutilizable
├── I: Interface Segregation
│   └─ Interfaz clara y tipada
└── D: Dependency Inversion
    └─ No depende de frameworks específicos

useGenerateReportMutation.tsx
├── S: Single Responsibility
│   └─ Solo maneja la mutación y errores API
├── O: Open/Closed
│   └─ Callbacks opcionales para extensión
├── L: Liskov Substitution
│   └─ Return type consistente
├── I: Interface Segregation
│   └─ Expone solo lo necesario
└── D: Dependency Inversion
    └─ Recibe callbacks en lugar de depender de componentes
```

---

### 🔄 Estados y Transiciones

```
                    ┌─────────────────┐
                    │  IDLE (inicial) │
                    └────────┬────────┘
                             │
                  Usuario escribe datos
                             │
                             ↓
                    ┌─────────────────┐
                    │  FORM_DIRTY     │ ← Errores locales pueden mostrarse
                    └────────┬────────┘
                             │
                  Usuario presiona submit
                             │
                             ↓
                    ┌─────────────────┐
                    │  LOADING        │ ← Button deshabilitado, spinner
                    └────────┬────────┘
                             │
         ┌───────────────────┼───────────────────┐
         │                   │                   │
    Valida OK          Valida FAIL         Error de red
         │                   │                   │
         ↓                   ↓                   ↓
  ┌────────────┐  ┌──────────────────┐  ┌──────────────┐
  │ SUCCESS    │  │ VALIDATION_ERROR │  │ NETWORK_ERROR│
  │ (reporte   │  │ (mostrar errores)│  │ (retry)      │
  │  generado) │  │ → form.errors    │  │              │
  └────────────┘  └──────────────────┘  └──────────────┘
```

---

### 📊 Tabla Comparativa: Hook vs useForm (Inertia)

| Aspecto | useReporteForm | useForm (Inertia) |
|---|---|---|
| **Creación** | `const form = useReporteForm()` | `const { data, setData, ... } = useForm()` |
| **Estado** | Local en componente | Global en Inertia |
| **Errores** | `form.errors` | `form.errors` |
| **Submit** | `await mutate(form.data)` | `form.post('/route')` |
| **Reset** | `form.resetForm()` | `form.reset()` |
| **Testing** | ✅ Fácil (puro) | ❌ Difícil (mock Inertia) |
| **Reutilización** | ✅ Cualquier contexto | ❌ Solo Inertia |
| **Tipado** | ✅ Fuerte | ⚠️ Débil |
| **Bundle** | ✅ Más pequeño | ❌ Más grande |
| **Control** | ✅ Total | ⚠️ Limitado |

---

### 🎬 Ciclo de Vida del Componente

```
                Mount ReporteSheetContent
                         │
                         ↓
        useReporteFormOptionsApi() [loading]
        useReporteForm() [state initialized]
        useGenerateReportMutation() [ready]
                         │
                         ↓
                 Render ReporteForm
                         │
                         ↓
        Usuario interactúa con campos
                         │
                    ┌────┴────┐
                    ↓         ↓
            form.setData()  Errors clear
                    │
                    ↓
            Re-render forma parcial
                    │
                    ↓
            Usuario hace submit
                    │
                    ↓
            mutate() [isPending = true]
                    │
            ┌───────┴───────┐
            ↓               ↓
         Success         Error
            │               │
            ↓               ↓
    onSuccess()       onError()
            │               │
            ↓               ↓
      Reporte view    Mostrar errores
            │               │
            ↓               ↓
        Cerrar sheet    Usuario corrige
                            │
                            └─→ Reintentar
```

---

### 🔐 Validación Multi-Capas

```
Frontend (React)
    ↓
useReporteForm validation
├─ Tipos TypeScript (compile-time)
├─ Required fields (setData)
└─ Format validation (opcional)
    ↓
User Submit
    ↓
useGenerateReportMutation
├─ Network request
└─ API response parsing
    ↓
Backend (Laravel)
    ↓
FormRequest validation (rules())
├─ Required
├─ Date format
├─ Array elements exist in DB
└─ Custom rules
    ↓
Error Response (422)
    ↓
Frontend (Re-render)
├─ parseApiErrors()
├─ Show AlertMessage
└─ Highlight fields
```

Este diagrama visualiza la arquitectura completa del sistema de reportes refactorizado.
