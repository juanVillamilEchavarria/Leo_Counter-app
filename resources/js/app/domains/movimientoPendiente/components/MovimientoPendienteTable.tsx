/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
