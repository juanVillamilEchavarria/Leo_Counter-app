/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { reporteApi } from '../../api/reporte.api'
import { useQuery } from '@tanstack/react-query'

export default function useReporteApi() {
  return useQuery({
    queryKey: ['reporte'],
    queryFn: reporteApi,
    staleTime: 0,
    retry: false
  })
}
