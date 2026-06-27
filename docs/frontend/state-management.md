# Gestión de Estado — Frontend de Leo Counter

El frontend de Leo Counter usa dos mecanismos complementarios para la gestión de estado: **Inertia.js** para el estado de página (datos iniciales de servidor) y **React Query (TanStack Query)** para datos que se refrescan dinámicamente (tablas paginadas server-side, reportes).

---

## 1. Inertia.js como Estado de Página

Inertia.js es el protocolo principal de comunicación entre Laravel y React. Convierte las respuestas de los controladores Laravel en `props` React sin necesidad de una API REST explícita.

### Cómo Funciona

```
1. El navegador navega a /cuentas
2. Laravel: CuentaController@index ejecuta Query → obtiene DTO
3. Laravel: Inertia::render('Cuentas/Index', ['cuentas' => $dto, 'auth' => $user])
4. Inertia: Serializa las props como JSON e inyecta en el componente React
5. React: El componente recibe las props tipadas vía usePage()
```

### Acceso a Props en Componentes

```typescript
// Index de cuenta
export default function Index({
  cuentas
}:{
  cuentas : {data: Cuenta[]}
}) {
    return (
        <SimpleTable data={cuentas} />
    );
}
```

### Formularios con Inertia (`useForm`)

Para operaciones de escritura basicas (crear, editar, eliminar), se usa el hook `useFormNormal` que implementa el `useForm` de Inertia:
```typescript
export default function useFormNormal<TData extends Record<string, any>>({
    action,
    method = 'post',
    data ,
}: FormDataNormalProps<TData>) {
    const form = useForm<TData>(data as TData);
    const {delete : destroy} = form
            const submit = (options?: Parameters<typeof form.post>[1]) => { // se le pueden pasar opciones, la posicion 1 es options de form.post
                  if (!action) return // si no hay action no hace nada
                  form.clearErrors() // limpia errores antes de enviar
                  const methodMap = {
                    post: () => form.post(action, options),
                    put: () => form.put(action, options),
                    patch: () => form.patch(action, options),
                    delete: () => destroy(action, options),
                  } as const
                  methodMap[method]?.()
          }
    const handleSubmit = (e: React.FormEvent<HTMLFormElement>, options?: Parameters<typeof form.post>[1] ) => {
        e.preventDefault();
        submit( options);   
    }
  return {
    form,
    submit,
    handleSubmit

  }
}
```
#### Ejemplo de implementacion
```typescript
import { useFormNormal } from "@/app/shared/hooks"
import { FormMethods } from "@/app/shared/types/components"
import { type MovimientoFijo, MovimientoFijoActions} from "../types/movimientoFijo.types"
export default function useMovimientoFijo({
    method = 'post',
    id,
    data
}:{
    method ?: keyof typeof FormMethods,
    id ?: string | null
    data ?: MovimientoFijo
}) {
    const action = (() => {
                const current = MovimientoFijoActions[method]
                    if (typeof current === 'function') {
                      return id ? current(id) : ''
                    }
                    return current
            })() // es una funcion que se llama inmediatamente para obtener la accion correcta segun el metodo y el id
             
         const { form, handleSubmit, submit } = useFormNormal<MovimientoFijo>({
             action,
             data: data ?? {} as MovimientoFijo,
             method
         })
  return {
    form,
    submit,
    handleSubmit
  }
}
```

#### Llamado desde componente:
```typescript
export default function Create({
    options
}:{
    options: MovimientoFijoFormOptions
}) {

    const {form, handleSubmit}= useMovimientoFijo({})
  return (
    <div className="section">
        <CreateOrEditDescription type="create" model="Movimiento Fijo" />
        <CreateOrEditFormSection
        buttonHref={MovimientoFijoRoutes.index()}
        >
            <MovimientoFijoForm {...form} submit={handleSubmit} options={options} />
        </CreateOrEditFormSection>
    </div>
  )
}
```


`useForm` gestiona automáticamente:
- El estado del formulario.
- Los errores de validación devueltos por Laravel.
- El estado `processing` (para deshabilitar el botón de envío).
- El reset del formulario al éxito.

---

## 2. React Query (TanStack Query) para Tablas Server-Side

Las tablas que muestran grandes volúmenes de datos (Movimientos históricos, Transferencias, Presupuestos históricos, Auditorías) usan **React Query** para cargar datos de forma paginada desde los endpoints de `api.php`.

### Patrón de Uso

```typescript
// hook para el reactquery
export default function useServerSideTable<T extends Record<string, any>>({
    endpoint,
    queryKey,
    params,
    enabled = true
}: UseServerSideTableProps) {
  return useQuery({
    queryKey: [...queryKey, params],
    queryFn:  () =>{ 
            return apiRequest<ServerSideTableResponse<T>, T>({ 
            method: ApiMethods.get,
            url: endpoint,
            params: convertServerSideQueryParams(params)
            })
    },
    enabled,
    placeholderData: (previousData)=> previousData
  })
}
// hook para manejar la tabla de serverside
export default function useServerSideTanStackTable<T extends Record<string, any>>({
    columns,
    endpoint,
    queryKey,
    initialPageSize = 10
}: UseServerSideTanStackTableProps<T>) {
  const [pagination, setPagination] = useState<PaginationState>({
    pageIndex: 0,
    pageSize: initialPageSize,
  });
 
  const [sorting, setSorting] = useState<SortingState>([]);
  const [globalFilter, setGlobalFilter] = useState('');

  const { data : response, isLoading , isFetching, isError, error}= useServerSideTable<T>({
    endpoint,
    queryKey,
    params: {
      pagination,
      sorting,
      globalFilter
    }
  })

  const data = useMemo(()=> response?.data ?? [], [response]);
  const pageCount = useMemo(()=> response?.meta?.lastPage ?? 0 , [response]);


  const table = useReactTable<T>({
        data,
        columns : columns,
        pageCount,
        state: {
            pagination,
            sorting,
            globalFilter,
        },
        onPaginationChange: setPagination,
        onSortingChange: setSorting,
        onGlobalFilterChange: setGlobalFilter,
        getCoreRowModel: getCoreRowModel(),
        manualPagination: true, 
        manualSorting: true,    
        manualFiltering: true,  
    });

    const UpDown = useMemo<Record<'asc' | 'desc', JSX.Element>>(
        () => ({
            asc: <i className="fa-solid fa-caret-up" />,
            desc: <i className="fa-solid fa-caret-down" />,
        }),
        []
    );

    return {
        table,
        data,
        metadata: response?.meta,
        isLoading,
        isFetching,
        isError,
        error,
        UpDown,
        globalFilter,
        setGlobalFilter,
    };
}
```

### Integración con TanStack Table

```typescript
interface TanStackTableServerSideProps<T> {
    columns: ColumnDef<T, any>[];
    endpoint: string;
    queryKey: string[];
    pageSize?: number;
}

export default function TanStackTableServerSide<T extends Record<string, any>>({
    columns,
    endpoint,
    queryKey,
    pageSize = 10,
}: TanStackTableServerSideProps<T>) {
    const {entries, setEntries} = useEntries({value:pageSize});
    const {
        table,
        isLoading,
        isFetching,
        isError,
        error,
        UpDown,
        globalFilter,
        setGlobalFilter,
    } = useServerSideTanStackTable({
        columns,
        endpoint,
        queryKey,
        initialPageSize: entries,
    });
    const controller = useTanStackPagination(table);
    if (isError) {
        return (
            <div className="p-4 bg-red-50 border border-red-200 rounded">
                <p className="text-red-600">Error al cargar datos: {error?.message}</p>
            </div>
        );
    }
    return (
       // ...
    );
}

```

El componente `TanStackTableServerSide` recibe:
- Una función de fetching (hook de React Query).
- Las columnas definidas (`ColumnDef<T>[]`).
- Opciones de configuración (búsqueda, filas por página, etc.).

---

## 3. Estado de UI Local (React `useState`)

Para estado puramente de UI (apertura de modales, elementos seleccionados), se usa el hook `useModalItem` compartido:

```typescript
// Patrón estándar en módulos CRUD
const { selectedItem, isOpen, openModal, closeModal } = useModalItem<Cuenta>();
```

Este hook encapsula el patrón de "ítem seleccionado + modal abierto" que se repite en todos los módulos con operaciones de edición y eliminación.

---

## 4. Estado de Autenticación

El estado del usuario autenticado se obtiene directamente de las props de Inertia compartidas por Laravel:

```typescript
const { auth } = usePage().props;
// auth.user.role === 'admin' → muestra opciones de administrador
```

No se usa un store global para la autenticación; Inertia garantiza que `auth` esté siempre disponible en cada página.

---

## 5. Modo Oscuro / Claro

El sistema de temas usa **variables CSS semánticas** en `resources/css/app.css` junto con el componente `PageModeSelect`. El modo se almacena en `localStorage` y se aplica mediante una clase CSS en el elemento raíz.

---

## Resumen de Estrategias por Tipo de Dato

| Tipo de dato | Estrategia | Herramienta |
|-------------|-----------|-------------|
| Datos iniciales de página (p. ej., lista de categorías para un select) | Props de Inertia | Inertia |
| Formularios de escritura (crear/editar) | Estado de formulario Inertia | `useForm` de `@inertiajs/react` |
| Tablas paginadas server-side (movimientos, transferencias, auditorías) | Fetch asíncrono | `useQuery` de `@tanstack/react-query` |
| Estado de UI local (modales, toggles) | Estado local React | `useState`, `useModalItem` |
| Usuario autenticado | Props compartidas Inertia | `usePage().props.auth` |
