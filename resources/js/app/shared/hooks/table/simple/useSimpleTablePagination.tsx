import { useState, useCallback, useMemo } from "react"

// toca hacer bastante logica aqui porque es para la paginacion para una tabla normal
export default function useSimplePagination(totalRows: number, pageSize = 10) {
  const [page, setPage] = useState(0) //estado para manejar la pagina actual
  const totalPages = Math.ceil(totalRows / pageSize) // calcula el total de paginas, redondea hacia arriba
  const canNext= page < totalPages-1
  const canPrev = page>0
  //usecallback para guardar la funcion y evitar renders innecesarios
  const next = useCallback(() => {
    setPage(p => Math.min(p + 1, totalPages - 1))
  }, [totalPages])

  const prev = useCallback(() => {
    setPage(p => Math.max(p - 1, 0))
  }, [])

  const goTo = useCallback((p: number) => {
    setPage(Math.max(0, Math.min(p, totalPages - 1)))
  }, [totalPages])

  //useMemo para guardar el valor del controller y evitar renders innecesarios
  const controller = useMemo(() => ({
    page,
    totalPages,
    canPrev,
    canNext,
    next,
    prev,
    goTo,
  }), [page, totalPages, canPrev, canNext, next, prev, goTo])

  return controller
}
