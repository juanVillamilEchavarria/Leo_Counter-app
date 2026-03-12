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
