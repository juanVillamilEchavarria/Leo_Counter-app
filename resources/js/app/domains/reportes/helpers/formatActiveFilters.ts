import { type ReporteFormData } from '../types/reporte.types'
import { type Categoria } from '../../categoria'
import { type Cuenta } from '../../cuenta'

/**
 * Formatea los datos del formulario a un formato legible para los filtros activos
 * @param formData - Datos del formulario de reportes
 * @returns Objeto con periodo, categorias y cuentas formateados
 */
export const formatActiveFilters = (formData: ReporteFormData) => {
  const formatDate = (dateString: string): string => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleDateString('es-MX', { year: 'numeric', month: 'long', day: 'numeric' })
  }

  const periodo = formData.startDate && formData.endDate
    ? `${formatDate(formData.startDate)} - ${formatDate(formData.endDate)}`
    : 'Período no especificado'

  const categorias = !formData.only_categorias_fijas 
            ? (formData.categorias.length > 0
                ? formData.categorias.map((cat: Categoria) => cat.nombre)
                : 'Todas las categorias')
            : 'Todas las categorias fijas'

  const cuentas = formData.cuentas.length > 0
    ? formData.cuentas.map((cuenta: Cuenta) => cuenta.nombre)
    : 'Todas las cuentas'

  return {
    periodo,
    categorias,
    cuentas
  }
}
