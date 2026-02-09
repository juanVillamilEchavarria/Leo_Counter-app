import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import { useSimpleTable } from "@/app/shared/hooks"
import { PropietarioColumns } from "./columns/propietarios.columns"
import { type Propietario, type PropietarioTableData } from "../types/propietario.types"
import { useMemo } from "react"

export default function PropietarioTable({
  pageSize = 10,
  data,
  onSelect
}: {
  pageSize?: number,
  data: PropietarioTableData[],
  onSelect: (item: PropietarioTableData, modalType: string) => void
}) {
  const {data: paginatedData}  = useSimpleTable({
    data,
    pageSize,
   })
  const columns = useMemo(()=>{
    return PropietarioColumns({
      onSelect
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
