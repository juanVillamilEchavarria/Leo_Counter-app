/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useState } from "react"
import { type ReporteApiResponse } from "../../types/reporte.types"

interface useReporteApiDataProps{
    initialData: ReporteApiResponse | undefined
    initialIsLoading?: boolean
    initialError?: any
}
export default function useReporteApiData({
    initialData,
    initialIsLoading = false,
    initialError = null
}: useReporteApiDataProps) {
    const [data, setData] = useState<ReporteApiResponse>(initialData ?? {} as ReporteApiResponse)
    const [isLoading, setIsLoading] = useState(initialIsLoading)
    const [error, setError] = useState(initialError)
  return {
    data,
    setData,
    isLoading,
    setIsLoading,
    error,
    setError
  }
}
