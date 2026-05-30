/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useState, useCallback, type Dispatch, type SetStateAction } from "react"

const buildDefaultFilters = () => {
  return {
    periodo: 'Últimos 6 meses',
    categorias: 'Todas las categorias',
    cuentas: 'Todas las cuentas'
  }
}

/**
 * Interface para el setter de filtros activos
 * Contiene las funciones para actualizar cada filtro
 */
export interface SetActiveReportFilters {
  setPeriodo: Dispatch<SetStateAction<string>>
  setCategorias: Dispatch<SetStateAction<string | string[]>>
  setCuentas: Dispatch<SetStateAction<string | string[]>>
  reset: () => void
}

/**
 * Hook que maneja el estado de los filtros activos en reportes
 * Proporciona acceso a los filtros y funciones para actualizarlos y resetearlos
 * @returns {Object} Objeto con estado de filtros, setters y función reset
 */
export default function useActiveReportFilters() {
  const defaultFilters = buildDefaultFilters()
  const [periodo, setPeriodo] = useState(defaultFilters.periodo)
  const [categorias, setCategorias] = useState<string | string[]>(defaultFilters.categorias)
  const [cuentas, setCuentas] = useState<string | string[]>(defaultFilters.cuentas)
  

  const reset = useCallback(() => {
    setPeriodo(defaultFilters.periodo)
    setCategorias(defaultFilters.categorias)
    setCuentas(defaultFilters.cuentas)
  }, [])

  return {
    periodo,
    setPeriodo,
    categorias,
    setCategorias,
    cuentas,
    setCuentas,
    reset
  } as const
}
