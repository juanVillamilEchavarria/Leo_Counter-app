import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import { useSimpleTable } from "@/app/shared/hooks"
import { CategoriaColumns } from "./columns/categoria.columns"
import { type Categoria } from "../types/categoria.types"
import { useMemo } from "react"

export default function CategoriaTable({
  data,
  pageSize = 10,
  onSelect
}: {
  data: Categoria[],
  pageSize?: number,
  onSelect: (item: Categoria, modalType: string) => void
}) {
  const {data: paginatedData}  = useSimpleTable({
    data,
    pageSize,
   })
  const columns = useMemo(()=>{
    return CategoriaColumns({
      onSelect: (row: Categoria) => {
        onSelect(row, 'delete')
      }
    })
  }, [onSelect])

  return (
    <SimpleTable
      data={paginatedData}
      columns={columns}
      pagination={true}
      pageSize={pageSize}
    />
  )
}
