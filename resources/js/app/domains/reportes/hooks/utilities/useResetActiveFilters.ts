/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useCallback, useState } from 'react'
import { useQueryClient } from '@tanstack/react-query'
import { type SetActiveReportFilters } from '../Charts/useActiveReportFilters'

interface UseResetActiveFiltersProps {
  setData: (data: any) => void
  setIsLoading: (isLoading: boolean) => void
  setError: (error: any) => void
  setActiveReportFilters: SetActiveReportFilters
}

/**
 * Hook para manejar el reset de filtros activos y re-ejecutar la query de reportes
 * Maneja la lógica completa del reset de forma limpia y reutilizable
 */
export const useResetActiveFilters = ({
  setData,
  setIsLoading,
  setError,
  setActiveReportFilters
}: UseResetActiveFiltersProps) => {
  const [isResetting, setIsResetting] = useState(false)
  const queryClient = useQueryClient()

  const reset = useCallback(async () => {
    try {
      setIsResetting(true)
      setError(null)

      // Reset los filtros activos a sus valores por defecto
      setActiveReportFilters.reset()

      // Invalidate y refetch la query de reportes
      await queryClient.invalidateQueries({ queryKey: ['reporte'] })
      const data = await queryClient.fetchQuery({ queryKey: ['reporte'] })

      setData(data)
      setIsLoading(false)
    } catch (error) {
      setError(error)
      setIsLoading(false)
    } finally {
      setIsResetting(false)
    }
  }, [queryClient, setData, setError, setIsLoading, setActiveReportFilters])

  return { reset, isResetting }
}
