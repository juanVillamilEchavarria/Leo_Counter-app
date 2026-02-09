import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import { useSimpleTable } from "@/app/shared/hooks"
import { useMemo } from "react"
import { MovimientoEspontaneoColumns } from "./columns/movimientoEspontaneo.columns"
import { type MovimientoEspontaneoTableData } from "../types/movimientoEspontaneo.types"

export default function MovimientoEspontaneoTable({
  data,
  pageSize = 10,
  onSelect
}:{
  data: MovimientoEspontaneoTableData[],
  pageSize?: number
  onSelect: (item: MovimientoEspontaneoTableData, modalType: string) => void
}) {
  const columns = useMemo(()=>{
    return MovimientoEspontaneoColumns({
      onSelect
    })
  }, [onSelect])
  const {data: paginatedData, pagination}  = useSimpleTable({
    data,
    pageSize
  })
  return (
    <SimpleTable
    data={paginatedData}
    pagination={true}
    columns={columns}
    pageSize={pageSize}
    controller={pagination}
     />
  )
}
