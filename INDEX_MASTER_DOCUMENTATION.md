# Índice Maestro - Documentación Completa del Sistema de Reportes

## 📚 Bienvenida

Este índice proporciona una guía completa para entender, testear e implementar el sistema de reportes financieros del proyecto Leo Counter App. Se han creado 5 documentos detallados que cubren todos los aspectos de la arquitectura.

---

## 📑 Documentos Disponibles

### 1. **INVESTIGATION_REPORT_CLASSES.md** 
   🎯 **Análisis Completo de Clases**
   - Ubicación: [INVESTIGATION_REPORT_CLASSES.md](INVESTIGATION_REPORT_CLASSES.md)
   - **Contenido:**
     - Descripción detallada de cada clase
     - Ubicación de archivos con rutas relativas
     - Métodos principales y sus responsabilidades
     - Dependencias de cada componente
     - Diagramas de flujo de datos
     - Puntos clave para testing
   - **Para quién:** Desarrolladores que necesitan entender la estructura completa
   - **Tiempo de lectura:** 20-30 minutos

---

### 2. **QUICK_REFERENCE.md**
   ⚡ **Referencia Rápida de Métodos y Clases**
   - Ubicación: [QUICK_REFERENCE.md](QUICK_REFERENCE.md)
   - **Contenido:**
     - Resumen de cada clase en formato tabla
     - Constructores, métodos públicos, privados
     - Propiedades y tipos
     - Tabla de tipos de estadísticas
     - Atajos de búsqueda
     - Ejemplos de uso rápidos
     - Configuración esperada
   - **Para quién:** Desarrolladores que necesitan buscar algo específico
   - **Tiempo de lectura:** 5-10 minutos (consulta rápida)

---

### 3. **ARCHITECTURE_VISUAL_SUMMARY.md**
   📊 **Diagramas y Estructura Visual**
   - Ubicación: [ARCHITECTURE_VISUAL_SUMMARY.md](ARCHITECTURE_VISUAL_SUMMARY.md)
   - **Contenido:**
     - Diagrama de capas (HTTP → Application → Domain → Infrastructure)
     - Diagrama de flujo de datos completo (request → response)
     - Matriz de responsabilidades
     - Flujo de inyección de dependencias
     - Tabla de dependencias directas
     - Tipos de datos clave
     - Enums principales
     - Especificaciones de negocio
     - Rutas HTTP
     - Patrones SOLID aplicados
   - **Para quién:** Arquitectos y senior developers
   - **Tiempo de lectura:** 15-25 minutos

---

### 4. **FILE_MAP_AND_LINES.md**
   🗂️ **Mapa de Archivos con Números de Línea**
   - Ubicación: [FILE_MAP_AND_LINES.md](FILE_MAP_AND_LINES.md)
   - **Contenido:**
     - Ubicación exacta de cada archivo
     - Números de línea para cada método
     - Tabla de secciones por componente
     - Patrones de búsqueda útiles
     - Checklist de modificaciones comunes
     - Referencias cruzadas
     - Notas de depuración
   - **Para quién:** Developers que necesitan ubicar código específico
   - **Tiempo de lectura:** 3-5 minutos (búsqueda rápida)

---

### 5. **TESTING_EXAMPLES_AND_CHECKLIST.md**
   ✅ **Ejemplos de Tests y Checklist Completo**
   - Ubicación: [TESTING_EXAMPLES_AND_CHECKLIST.md](TESTING_EXAMPLES_AND_CHECKLIST.md)
   - **Contenido:**
     - Tests unitarios completos para cada capa
     - Tests de integración
     - Tests E2E
     - Ejemplos de fixtures
     - Checklist de testing por capa
     - Cobertura esperada
   - **Para quién:** QA engineers y developers responsables de tests
   - **Tiempo de lectura:** 25-35 minutos

---

### 6. **TESTING_EXECUTION_GUIDE.md**
   🧪 **Guía Práctica de Ejecución de Tests**
   - Ubicación: [TESTING_EXECUTION_GUIDE.md](TESTING_EXECUTION_GUIDE.md)
   - **Contenido:**
     - Configuración inicial de testing
     - Estructura de directorios de tests
     - Comandos para ejecutar tests
     - Cómo escribir tests unitarios
     - Cómo escribir tests de integración
     - Mocking y stubbing
     - Factories y fixtures
     - Data providers
     - Testing de queries Eloquent
     - Cobertura de código
     - Debugging de tests
     - Integración con CI/CD
     - Comandos rápidos
   - **Para quién:** Developers que necesitan ejecutar y escribir tests
   - **Tiempo de lectura:** 30-40 minutos

---

## 🎯 Guía de Lectura Recomendada

### Para Nueva Contexto (Onboarding)
1. **ARCHITECTURE_VISUAL_SUMMARY.md** - Entender estructura general (20 min)
2. **INVESTIGATION_REPORT_CLASSES.md** - Conocer clases específicas (30 min)
3. **QUICK_REFERENCE.md** - Guardar como referencia rápida (5 min)

**Tiempo total:** ~55 minutos

---

### Para Crear Tests
1. **TESTING_EXAMPLES_AND_CHECKLIST.md** - Ver ejemplos (30 min)
2. **TESTING_EXECUTION_GUIDE.md** - Aprender cómo ejecutar (40 min)
3. **QUICK_REFERENCE.md** - Consultar métodos (5 min)

**Tiempo total:** ~75 minutos

---

### Para Implementar Nueva Funcionalidad
1. **ARCHITECTURE_VISUAL_SUMMARY.md** - Entender flujo (20 min)
2. **FILE_MAP_AND_LINES.md** - Ubicar código existente (5 min)
3. **INVESTIGATION_REPORT_CLASSES.md** - Entender clases relevantes (15 min)
4. **QUICK_REFERENCE.md** - Referencia de métodos (5 min)

**Tiempo total:** ~45 minutos

---

### Para Debuggear Problema
1. **FILE_MAP_AND_LINES.md** - Ubicar el código (5 min)
2. **QUICK_REFERENCE.md** - Entender método (5 min)
3. **ARCHITECTURE_VISUAL_SUMMARY.md** - Entender flujo general (10 min)

**Tiempo total:** ~20 minutos

---

## 🔍 Búsqueda Rápida por Tópico

### Clases y Ubicaciones
| Tópico | Documento | Sección |
|--------|-----------|---------|
| DateRange | INVESTIGATION_REPORT_CLASSES.md | 1.1 |
| ReporteQueryResult | INVESTIGATION_REPORT_CLASSES.md | 1.1 |
| ReporteQuery | INVESTIGATION_REPORT_CLASSES.md | 1.1 |
| MovimientoReportStatisticType | INVESTIGATION_REPORT_CLASSES.md | 1.2 |
| GenerateReportHandler | INVESTIGATION_REPORT_CLASSES.md | 2.2 |
| MovimientoReportGenerationContributor | INVESTIGATION_REPORT_CLASSES.md | 2.2 |
| KPIAssembler | INVESTIGATION_REPORT_CLASSES.md | 2.5 |
| EloquentKPIsQueryExecutor | INVESTIGATION_REPORT_CLASSES.md | 3.1 |
| ReporteApiController | INVESTIGATION_REPORT_CLASSES.md | 4.1 |

---

### Métodos Específicos
| Método | Documento | Sección |
|--------|-----------|---------|
| DateRange::diffDays() | QUICK_REFERENCE.md | 1.1 |
| ReporteQueryResult::add() | QUICK_REFERENCE.md | 1.1 |
| GenerateReportHandler::handle() | QUICK_REFERENCE.md | 2.1 |
| KPIAssembler::assemble() | QUICK_REFERENCE.md | 2.5 |
| PercentageService::calculatePercentageChange() | QUICK_REFERENCE.md | 4.0 |

---

### Arquitectura y Diseño
| Tópico | Documento | Sección |
|--------|-----------|---------|
| Diagrama de capas | ARCHITECTURE_VISUAL_SUMMARY.md | 1 |
| Flujo de datos | ARCHITECTURE_VISUAL_SUMMARY.md | 2 |
| Matriz de responsabilidades | ARCHITECTURE_VISUAL_SUMMARY.md | 3 |
| Inyección de dependencias | ARCHITECTURE_VISUAL_SUMMARY.md | 4 |
| Patrones utilizados | ARCHITECTURE_VISUAL_SUMMARY.md | 11 |

---

### Testing
| Tópico | Documento | Sección |
|--------|-----------|---------|
| Ejemplos de tests unitarios | TESTING_EXAMPLES_AND_CHECKLIST.md | 1 |
| Ejemplos de tests de integración | TESTING_EXAMPLES_AND_CHECKLIST.md | 3 |
| Tests E2E | TESTING_EXAMPLES_AND_CHECKLIST.md | 5 |
| Ejecución de tests | TESTING_EXECUTION_GUIDE.md | 3 |
| Mocking y stubbing | TESTING_EXECUTION_GUIDE.md | 6 |

---

## 📊 Estructura del Sistema

```
┌─────────────────────────────────────────────────┐
│          HTTP LAYER (Controllers)               │
│  ReporteApiController → ReporteResource         │
└──────────────────────┬──────────────────────────┘
                       │
┌──────────────────────▼──────────────────────────┐
│     APPLICATION LAYER (Use Cases)               │
│  GenerateReportHandler                          │
│  └─ Contribuidores + Orquestadores              │
│  └─ Ensambladores + Mappers                     │
└──────────────────────┬──────────────────────────┘
                       │
┌──────────────────────▼──────────────────────────┐
│      DOMAIN LAYER (Business Logic)              │
│  Value Objects: DateRange, ReporteQuery, etc.   │
│  Enums: MovimientoReportStatisticType           │
│  Contracts: ReportContributorContract, etc.     │
└──────────────────────┬──────────────────────────┘
                       │
┌──────────────────────▼──────────────────────────┐
│   INFRASTRUCTURE LAYER (Data Access)            │
│  Query Handlers: EloquentKPIsQueryExecutor, etc. │
│  Builders, Resolvers, Collections               │
└─────────────────────────────────────────────────┘
```

---

## 🛠️ Herramientas y Comandos

### Ejecutar Tests
```bash
# Todos los tests
./vendor/bin/pest

# Tests unitarios
./vendor/bin/pest tests/Unit

# Tests de feature
./vendor/bin/pest tests/Feature

# Test específico
./vendor/bin/pest --filter="DateRange"
```

---

### Ver Cobertura
```bash
# Cobertura en línea de comandos
./vendor/bin/pest --coverage

# Cobertura en HTML
./vendor/bin/pest --coverage --coverage-html=coverage
```

---

### Crear Tests
```bash
# Test unitario
php artisan make:test Unit/Domains/Reporte/ValueObjects/DateRangeTest

# Test de feature
php artisan make:test Feature/Http/Controllers/ReporteControllerTest
```

---

## 📈 Estadísticas del Proyecto

| Métrica | Valor |
|---------|-------|
| Documentos creados | 6 |
| Clases documentadas | 28+ |
| Métodos documentados | 70+ |
| Rutas HTTP documentadas | 2 |
| Enums documentados | 2 |
| Contratos/Interfaces | 5 |
| Ejemplos de tests | 40+ |

---

## ⚡ Checklist Inicial

Antes de empezar con los tests:

- [ ] Leer ARCHITECTURE_VISUAL_SUMMARY.md
- [ ] Leer secciones relevantes de INVESTIGATION_REPORT_CLASSES.md
- [ ] Guardar QUICK_REFERENCE.md como favorito
- [ ] Guardar FILE_MAP_AND_LINES.md como referencia
- [ ] Revisar TESTING_EXAMPLES_AND_CHECKLIST.md
- [ ] Seguir TESTING_EXECUTION_GUIDE.md para configurar tests
- [ ] Ejecutar tests localmente: `./vendor/bin/pest`
- [ ] Ver cobertura: `./vendor/bin/pest --coverage`

---

## 🔗 Enlaces a Documentos

### PDF/Markdown (en el proyecto)
- [1. INVESTIGATION_REPORT_CLASSES.md](INVESTIGATION_REPORT_CLASSES.md)
- [2. QUICK_REFERENCE.md](QUICK_REFERENCE.md)
- [3. ARCHITECTURE_VISUAL_SUMMARY.md](ARCHITECTURE_VISUAL_SUMMARY.md)
- [4. FILE_MAP_AND_LINES.md](FILE_MAP_AND_LINES.md)
- [5. TESTING_EXAMPLES_AND_CHECKLIST.md](TESTING_EXAMPLES_AND_CHECKLIST.md)
- [6. TESTING_EXECUTION_GUIDE.md](TESTING_EXECUTION_GUIDE.md)

---

## 📝 Notas Importantes

### Convenciones del Proyecto
- **Value Objects** son inmutables
- **DTOs** transportan datos entre capas
- **Handlers** coordinan casos de uso
- **Assemblers** transforman datos para presentación
- **Resolvers** localizan implementaciones dinámicamente

### Dependencias Inyectadas
Todas las dependencias se inyectan via constructor, permitiendo fácil testing con mocks.

### Pattern DDD
El proyecto implementa Domain-Driven Design con:
- Entidades de dominio
- Value Objects
- Enums tipados
- Servicios de dominio
- Contratos bien definidos

---

## 🆘 Solución de Problemas

### No entiendo la arquitectura
→ Leer ARCHITECTURE_VISUAL_SUMMARY.md sección 1-2

### No encuentro dónde está una clase
→ Ver QUICK_REFERENCE.md o FILE_MAP_AND_LINES.md

### Quiero agregar un nuevo tipo de estadística
→ Leer ARCHITECTURE_VISUAL_SUMMARY.md sección 6, luego QUICK_REFERENCE.md "Encontrar por funcionalidad"

### Necesito saber qué testa una clase
→ Ver TESTING_EXAMPLES_AND_CHECKLIST.md sección correspondiente

### Quiero ejecutar un test específico
→ Ir a TESTING_EXECUTION_GUIDE.md sección 3.3

---

## 📞 Contacto y Actualizaciones

Este documento se debe actualizar cuando:
- Se agreguen nuevas clases al sistema de reportes
- Se cambien métodos principales
- Se refactoricen capas importantes
- Se agregen nuevos tipos de estadísticas

**Mantenedor:** Tu Equipo de Desarrollo
**Última actualización:** 17 de abril de 2026
**Versión:** 1.0.0

---

## 🎓 Próximas Lecturas Recomendadas

1. **Domain-Driven Design** por Eric Evans
2. **Clean Architecture** por Robert Martin
3. **PHP by Example** - Patterns and Best Practices
4. **Laravel's Official Documentation** - Testing section
5. **Pest Documentation** - pestphp.com

---

**¡Listo para empezar!** 🚀

Cada documento está diseñado para ser independiente pero complementario. Usa este índice como tu guía de navegación.
