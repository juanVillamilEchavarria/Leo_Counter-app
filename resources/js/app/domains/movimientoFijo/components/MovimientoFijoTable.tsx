import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import { useSimpleTable } from "@/app/shared/hooks"
import { MovimientoFijoColumns } from "./columns/movimientoFijo.columns"
import { type MovimientoFijoTableData } from "../types/movimientoFijo.types"
import { useMemo } from "react"

export default function MovimientoFijoTable({
  data,
  onSelect
}: {
  data: MovimientoFijoTableData[],
  onSelect: (item: MovimientoFijoTableData, modalType: string) => void
}) {
  const {data: paginatedData}  = useSimpleTable({
    data,
    pageSize: data.length,
   })
  const columns = useMemo(()=>{
    return MovimientoFijoColumns({
      onSelect: (row: MovimientoFijoTableData) => {
        onSelect(row, 'delete')
      }
    })
  }, [onSelect])

  return (
    <SimpleTable
      data={paginatedData}
      columns={columns}
      pagination={false}
    />
  )
}
