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
  const columns = useMemo(()=>{
    return MovimientoFijoColumns({
      onSelect: (row: MovimientoFijoTableData) => {
        onSelect(row, 'delete')
      }
    })
  }, [onSelect])

  return (
    <SimpleTable
      data={data}
      pageSize={10}
      columns={columns}
      pagination={true}
    />
  )
}
