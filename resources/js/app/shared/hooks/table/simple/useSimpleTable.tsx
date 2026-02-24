import { useMemo } from "react"
import useSimplePagination from "./useSimpleTablePagination"
import useEntries from "../pagination/useEntries"

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
