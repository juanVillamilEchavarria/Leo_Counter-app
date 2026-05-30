/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useState, useCallback, useMemo } from "react"

/**
 * hook para manejar el filtrado por paginacion de las tablas client side
 * @param {number} totalRows 
 * @param {number} pageSize 
 * @returns {page: number, totalPages: number, canNext: boolean, canPrev: boolean, next: () => void, prev: () => void, goTo: (p: number) => void} 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
export default function useSimplePagination(totalRows: number, pageSize = 10) {
  const [page, setPage] = useState(0) //estado para manejar la pagina actual
  const totalPages = Math.ceil(totalRows / pageSize) // calcula el total de paginas, redondea hacia arriba
  const canNext= page < totalPages-1
  const canPrev = page>0
  /**
   * funcion para ir a la siguiente pagina
   */
  const next = useCallback(() => {
    setPage(p => Math.min(p + 1, totalPages - 1))
  }, [totalPages])

  /**
   * funcion para ir a la pagina anterior
   */
  const prev = useCallback(() => {
    setPage(p => Math.max(p - 1, 0))
  }, [])

  /**
   * funcion para ir a una pagina especifica
   */
  const goTo = useCallback((p: number) => {
    setPage(Math.max(0, Math.min(p, totalPages - 1)))
  }, [totalPages])
  /**
   * Controlador de la paginacion
   */
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
