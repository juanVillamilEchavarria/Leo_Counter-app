# ADR-0002: Adopción de Inertia.js con React 19 como capa de presentación

- **Estado:** Aceptada
- **Fecha:** 2026-06-02
- **Autores:** Juan Esteban Villamil Echavarria

---

## Contexto

Leo Counter es una aplicación autoalojada de gestión financiera personal/familiar. Requiere:
- Una UI reactiva y moderna (transiciones, formularios con validación en tiempo real, tablas con server-side pagination).
- Autenticación basada en sesión (no tokens JWT), dado el modelo de privacidad absoluta y uso local.
- Sin necesidad de una API RESTful pública completa, ya que el único cliente es la propia aplicación.
- Mantenimiento por un equipo pequeño (una sola persona), por lo que la complejidad de infraestructura debe minimizarse.

Una SPA desacoplada (React + API REST) requeriría manejar autenticación con tokens, CORS, y un servidor de API separado. Un servidor de templates Blade + AJAX requeriría duplicar validaciones en frontend y backend.

## Decisión

Se adopta **Inertia.js 2.0** como protocolo de comunicación entre Laravel y React 19, con las siguientes características:

- **Sin API REST separada**: Inertia convierte las respuestas de los controladores Laravel en `props` de React, eliminando la necesidad de serialización/deserialización explícita de API.
- **Autenticación con sesión**: Se usa la autenticación nativa de Laravel (sesión + cookie), aprovechando los middlewares `auth` y `AdminMiddleware`.
- **SSR-compatible**: Inertia soporta renderizado del lado del servidor si se requiere en el futuro.
- **TypeScript estricto**: Todo el frontend usa TypeScript para garantizar la compatibilidad entre las `props` de Inertia y los componentes React.

### Stack Frontend completo

| Tecnología | Versión | Rol |
|------------|---------|-----|
| React | 19 | UI Library |
| TypeScript | 5.x | Tipado estático |
| Inertia.js | 2.0 | Protocolo Laravel ↔ React |
| TanStack Table | v8 | Tablas server-side paginadas |
| React Query | v5 | Fetching de datos para tablas API |
| Tailwind CSS | 4.x | Estilos utilitarios |
| Vite | 6.x | Bundler y servidor HMR |
| pnpm | 9.x | Gestor de paquetes |

### Patrón de comunicación Inertia

```
HTTP Request (navegador)
    │
    ▼
Laravel Controller
    │  → Ejecuta Query via QueryBus
    │  → Obtiene DTO de datos
    ▼
Inertia::render('Movimientos/Historicos/Index', ['movimientos' => $dto])
    │
    ▼
React Page Component (Inertia props)
    │  → <MovimientoTable /> con TanStack Table server-side
    ▼
Render en cliente
```

Para datos que requieren refetch sin navegación completa (tablas paginadas), se usa **React Query** combinado con los endpoints de `api.php`:

```typescript
// Ejemplo: tabla server-side de movimientos
const { data } = useQuery({
    queryKey: ['movimientos', filters],
    queryFn: () => fetchMovimientosPaginated(filters),
});
```

## Alternativas Consideradas

| Alternativa | Pros | Contras |
|-------------|------|---------|
| Blade + jQuery | Mínima complejidad | Sin tipado, DX pobre, sin componentización |
| Next.js + API REST | SSR nativo, SEO | Requiere servidor Node, doble mantenimiento API, tokens JWT |
| Livewire + Alpine.js | Integración Laravel nativa | Menor ecosistema React, equipo con más experiencia en React |
| SPA React pura + API | Máxima separación | Duplica infraestructura, complica autenticación |

## Consecuencias

**Positivas:**
- Un solo modelo de autenticación (sesión Laravel).
- El backend controla qué datos expone como `props`, sin necesidad de Resources API para toda la UI.
- Los formularios usan `useForm` de Inertia para manejo de estado y errores de forma integrada.
- La arquitectura de páginas sigue la convención `resources/js/Pages/` con nombres que mapean a los controladores Laravel.

**Negativas / Trade-offs:**
- La arquitectura Inertia no es compatible con clientes móviles nativos sin añadir una API REST separada.
- Los endpoints de `api.php` (para tablas server-side y operaciones AJAX) deben mantenerse sincronizados con el modelo de datos.
- El hot module replacement (HMR) requiere ejecutar `pnpm run dev` dentro del contenedor Docker durante el desarrollo.

## Referencias

- `resources/js/Pages/` (páginas Inertia)
- `vite.config.ts`
- `routes/web.php` (rutas que renderizan páginas Inertia)
- `routes/api.php` (endpoints para React Query)
