import { getVisiblePages } from "@/app/shared/helpers"
import { type Table } from "@tanstack/react-table"
import { useMemo, useCallback } from "react"
export default function useTanStackPagination<T>(table: Table<T>) {
  const page = table.getState().pagination.pageIndex
  const totalPages = table.getPageCount()
  const canNext = table.getCanNextPage()
  const canPrev = table.getCanPreviousPage()
  const next =  useCallback(()=>{
    table.nextPage()
  }, [table])
  const prev = useCallback(()=>{
    table.previousPage()
  }, [table])
  const goTo = useCallback((p: number)=>{
    table.setPageIndex(p)
  }, [ table])

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