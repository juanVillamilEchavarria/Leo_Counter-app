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
import { PresupuestoMesActualColumns } from "./columns/presupuestoMesActual.columns"
import { type PresupuestoMesActualTableData } from "../types/presupuestoMesActual.types"
import { useMemo } from "react"

export default function PresupuestoMesActualTable({
  data,
  pageSize = 10,
  onSelect
}: {
  data: PresupuestoMesActualTableData[],
  pageSize?: number,
  onSelect: (item: PresupuestoMesActualTableData, modalType: string) => void
}) {
  const columns = useMemo(()=>{
    return PresupuestoMesActualColumns({
      onSelect: (row: PresupuestoMesActualTableData, modalType: string) => {
        onSelect(row, modalType)
      }
    })
  }, [onSelect])

  return (
    <SimpleTable
      data={data}
      columns={columns}
      pagination={true}
      pageSize={pageSize}
    />
  )
}
