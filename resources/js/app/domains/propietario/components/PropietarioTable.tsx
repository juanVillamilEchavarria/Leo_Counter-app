/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import { PropietarioColumns } from "./columns/propietarios.columns"
import { type PropietarioTableData } from "../types/propietario.types"
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
  const columns = useMemo(()=>{
    return PropietarioColumns({
      onSelect
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
