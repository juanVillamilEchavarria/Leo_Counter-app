/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useMemo } from "react"
import useSimplePagination from "./useSimpleTablePagination"

/**
 * hook para manejar la cantidad de datos a mostrar de la tabla
 * @param {TData[]} data 
 * @param {number} pageSize 
 * @returns {data: TData[], pagination: SimpleTablePagination}
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
export default function useSimpleTable<TData>({
  data = [],
  pageSize = 10,
}: {
  data: TData[]
  pageSize?: number
}) {
  const pagination = useSimplePagination(data.length, pageSize)
  const start = pagination.page * pageSize
  const end = start + pageSize

  const paginatedData = useMemo(
    () => data.slice(start, end),
    [data, start, end]
  )

  return {
    data: paginatedData,
    pagination
  } as const
}
