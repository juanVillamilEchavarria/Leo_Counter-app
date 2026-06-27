# Arquitectura Atómica del Frontend — Leo Counter

El frontend de Leo Counter organiza sus componentes React siguiendo un enfoque de **Arquitectura Atómica por Dominio**: los componentes se clasifican por su nivel de responsabilidad y reutilizabilidad, y se organizan en dos grandes grupos: **compartidos** (agnósticos del dominio) y **de dominio** (específicos de un módulo).

---

## Estructura de Directorios

```
resources/js/
├── app/
│   ├── domains/              ← Componentes y lógica específica de cada módulo
│   │   ├── auth/
│   │   │   ├── components/
│   │   │   ├── hooks/
│   │   │   ├── types/
│   │   │   └── index.ts
│   │   ├── categoria/
│   │   │   ├── components/   (CategoriaForm, CategoriaTable)
│   │   │   └── index.ts
│   │   ├── movimiento/
│   │   │   ├── components/
│   │   │   │   ├── columns/  (movimiento.columns.tsx)
│   │   │   │   ├── MovimientoTable.tsx
│   │   │   │   └── ShowMovimientoModal.tsx
│   │   │   ├── types/
│   │   │   └── index.ts
│   │   ├── presupuestoHistorico/
│   │   ├── historial/
│   │   ├── profile/
│   │   └── user/
│   └── shared/               ← Componentes compartidos por todos los módulos
│       ├── api/              (client.api.ts, financialValidate.api.ts)
│       ├── components/
│       │   ├── common/       ← Átomos y moléculas generales
│       │   ├── dropZone/     ← Upload de archivos
│       │   ├── form/         ← Controles de formulario
│       │   ├── header/
│       │   ├── modal/        ← Modales genéricos
│       │   ├── mode/
│       │   ├── navBar/
│       │   ├── sidebar/
│       │   ├── table/        ← Infraestructura de tablas
│       │   └── transitions/
│       └── ...
├── Layouts/
│   ├── AppLayout.tsx         ← Layout para usuarios autenticados
│   └── GuestLayout.tsx       ← Layout para páginas públicas
└── Pages/                    ← Páginas Inertia (un archivo por ruta)
    ├── Movimientos/
    │   ├── Historicos/Index.tsx
    │   └── Espontaneos/
    │       ├── Index.tsx
    │       └── Create.tsx
    ├── MovimientosFijos/
    ├── MovimientosPendientes/
    ├── Transferencias/
    ├── Presupuestos/
    ├── Cuentas/
    ├── Categorias/
    ├── Propietarios/
    ├── Usuarios/
    ├── Reportes/
    ├── Auditorias/
    ├── Configuracion/
    └── Home/
```

---

## Niveles de Componentes

### Nivel 1: Componentes Atómicos (`shared/components/common/`)

Son las unidades más pequeñas e indivisibles. No tienen estado propio relevante y reciben todo via props.

| Componente | Propósito |
|-----------|-----------|
| `Button` | Botón base del sistema de diseño |
| `Title` | Encabezado tipográfico |
| `Loading` | Indicador de carga |
| `Logo` | Logo de la aplicación |
| `AlertMessage` | Mensaje de alerta / feedback |
| `SuccessOrFailText` | Texto condicional éxito/error |
| `MoneyFlow` | Indicador visual de flujo de dinero (ingreso/gasto) |
| `PercentageFlow` | Barra de progreso de porcentaje |
| `ErrorResponse` | Visualización de errores de API |

### Nivel 2: Moléculas (`shared/components/`)

Combinaciones de átomos que forman unidades de UI con un propósito específico.

| Componente | Propósito |
|-----------|-----------|
| `Card` | Contenedor con estilos de tarjeta |
| `CreateButtonSection` | Sección con botón de creación y título |
| `CreateOrEditFormSection` | Wrapper de formulario create/edit |
| `SectionDescription` | Descripción contextual de una sección |
| `CrudButton` | Botón de acción CRUD (editar/eliminar) |
| `ItemSelected` / `ItemSelectedList` | Elemento seleccionado y su lista |
| `ShowFile` | Vista de un archivo adjunto |
| `SectionNavBar` / `SectionNavItem` | Navegación interna de sección |
| `FlashToastListener` | Escucha mensajes flash de Inertia y los muestra como toast |

### Nivel 3: Organismos (`shared/components/table/`, `shared/components/modal/`, etc.)

Componentes complejos que encapsulan comportamiento completo.

| Componente | Propósito |
|-----------|-----------|
| `TanStackTable` | Tabla cliente con TanStack Table v8 |
| `TanStackTableServerSide` | Tabla con paginación server-side via React Query |
| `SimpleTable` | Tabla simple sin paginación avanzada |
| `TablePagination` | Controles de paginación |
| `TableEntries` | Selector de registros por página |
| `Modal` | Modal base |
| `DeleteModal` | Modal de confirmación de eliminación |
| `ShowModal` | Modal de visualización de detalles |
| `DropZone` | Área de drag & drop para archivos |
| `SideBarApp` | Barra lateral de navegación principal |
| `Header` | Cabecera de la aplicación |

### Nivel 4: Componentes de Dominio (`app/domains/`)

Son componentes específicos de un módulo de negocio. Conocen los tipos del dominio.

| Módulo | Componentes |
|--------|-------------|
| `movimiento` | `MovimientoTable`, `ShowMovimientoModal`, `movimiento.columns.tsx` |
| `categoria` | `CategoriaForm`, `CategoriaTable` |
| `presupuestoHistorico` | `PresupuestoHistoricoTable`, `presupuesto.columns.ts` |
| `historial` | `HistorialTable` |
| `auth` | `LoginForm`, `RegisterForm`, `ResetPasswordForm` |
| `profile` | `ProfileForm`, `PasswordForm`, `ProfileNavBar` |
| `user` | `SelfUserCard`, `SelfOptionsCard` |

---

## Páginas Inertia (`resources/js/Pages/`)

Las páginas son el punto de entrada de cada ruta. Reciben `props` de Inertia directamente desde los controladores Laravel.

```typescript
// Ejemplo: resources/js/Pages/Movimientos/Historicos/Index.tsx
import { usePage } from '@inertiajs/react';

export default function Index({
  data
}:{
  data?: {data: MovimientoShowData}
}) {
  const {item, modal, setItem, open, close}= useModalItem<MovimientoShowData>()
  const descriptionItems=[
    {
      title: 'Consulta el historial de tus movimientos',
      description: 'Revisa el historial completo de tus ingresos y gastos para tener un control total sobre tus finanzas',
      icon: 'fa-solid fa-clock-rotate-left !text-yellow-300'

    },
    {
      icon: 'fa-solid fa-chart-line !text-green-400',
      title: 'Filtra por parametros',
      description: 'Filtra tus movimientos por fecha, nombre , categoria, cuenta o monto para encontrar lo que buscas',
    },
    {
      icon: 'fa-solid fa-magnifying-glass !text-blue-400',
      title: 'Consulta con detalles tus movimientos',
      description: 'Obtén información detallada sobre cada uno de tus movimientos dando click encima de su nombre en la tabla de movimientos',
    }

  ]

  useEffect(()=>{
    if(data){
      setItem(data.data)
    }
  },[data])
  return (
    <SectionTransition>
        <SectionDescriptionWithDetails
         principalTitle="Movimientos" 
        paragraph="Mira el historial de tus ingresos y gastos"
        items={descriptionItems}
         />
        <MovimientoTable onSelect={(item)=> open(item, 'show')} />
        <ShowMovimientoModal 
            movimiento={item}
            onClose={close}
            />
    </SectionTransition>
  )
}
```

---

## Convenciones de Nombrado

| Tipo | Convención | Ejemplo |
|------|-----------|---------|
| Componente React | PascalCase | `MovimientoTable.tsx` |
| Hook personalizado | `use` + PascalCase | `useModalItem.tsx` |
| Tipos TypeScript | PascalCase + `.types.ts` | `movimiento.types.ts` |
| Columnas de tabla | camelCase + `.columns.tsx` | `movimiento.columns.tsx` |
| API client | camelCase + `.api.ts` | `client.api.ts` |
| Barrel export | `index.ts` por módulo | `domains/movimiento/index.ts` |

---

## Layout de la Aplicación

```
AppLayout (autenticado)
├── SideBarApp (navegación principal)
│   ├── NavBar
│   │   ├── NavItemGroup
│   │   └── NavItem
│   └── SidebarDesktop / SidebarMobile
├── Header
│   └── GithubLink
└── {children} (página Inertia)
    └── FlashToastListener (mensajes flash)
```
