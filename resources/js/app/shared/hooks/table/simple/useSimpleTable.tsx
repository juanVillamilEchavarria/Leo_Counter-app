import { useState, useMemo } from "react"
import useSimplePagination from "./useSimpleTablePagination"
import { type SimpleTableColumn } from "@/app/shared/types/components"

export default function useSimpleTable<TData extends Record<string, any>>({ // este es el hook reutilizable que por default hace el delete con el modal
  data = [],
  pageSize = 10,
  tableColumns,
  formModelHook
}:{
  data: TData[],
  pageSize?: number,
  tableColumns: ({onDelete}: {onDelete: (item: TData, modal: string) => void}) => SimpleTableColumn<TData>[],
  formModelHook?: any
}) {
  const [itemSelected, setItemSelected] = useState<TData | null>(null)
  const [modalSelected, setModalSelected] = useState<string | null>(null)
  const columns = useMemo(() => 
    tableColumns({
      onDelete: (item: TData, modal: string) => {
          setItemSelected(item)
          setModalSelected(modal)
      }}),  
  [tableColumns]
)
        const formConfig = formModelHook?.({ method: 'delete', id: itemSelected?.id }) || {} // si no hay formModelHook devuelve un objeto vacio
        const handleSubmit = formConfig.handleSubmit || (() => {})

  const handleDelete = (e: React.FormEvent<HTMLFormElement>) => {
    if (!itemSelected) return
    handleSubmit(e)
    setItemSelected(null)
  }
  const pagination = useSimplePagination(data.length, pageSize)
  const start = pagination.page * pageSize
  const end = start + pageSize
  const paginatedData = useMemo(() => data.slice(start, end), [data, start, end])
  return {
    data: paginatedData,
    columns,
    pagination,
    itemSelected,
    modalSelected,
    setItemSelected,
    setModalSelected,
    handleDelete
  } as const
}
