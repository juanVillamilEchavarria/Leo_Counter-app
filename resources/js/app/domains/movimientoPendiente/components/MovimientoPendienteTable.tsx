import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import { useSimpleTable } from "@/app/shared/hooks"
import { MovimientoPendienteColumns } from "./columns/movimientoPendiente.columns"
import { type MovimientoPendienteTableData, type MovimientoPendienteShowData} from "../types/movimientoPendiente.types"
import {useMemo } from "react"
export default function MovimientoPendienteTable({
  data,
  onSelect
}: {
  data: MovimientoPendienteTableData[],
  onSelect: (item: MovimientoPendienteTableData, modalType: string) => void,
}) {
  const columns = useMemo(()=>{
    return MovimientoPendienteColumns({
      onSelect 
    })
  }, [MovimientoPendienteColumns])
  return (
    <>
      <SimpleTable
        data={data}
        columns={columns}
        pagination={false}
      />
    </>
  )
}
