import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import { useSimpleTable } from "@/app/shared/hooks"
import { PropietarioColumns } from "./columns/propietarios.columns"
import { type Propietario } from "../types/propietario.types"
import { useMemo } from "react"

export default function PropietarioTable({
  pageSize = 10,
  data,
  onSelect
}: {
  pageSize?: number,
  data: Propietario[],
  onSelect: (item: Propietario, modalType: string) => void
}) {
  const {data: paginatedData}  = useSimpleTable({
    data,
    pageSize,
   })
  const columns = useMemo(()=>{
    return PropietarioColumns({
      onSelect: (row: Propietario) => {
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
