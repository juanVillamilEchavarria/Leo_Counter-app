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
import { CategoriaColumns } from "./columns/categoria.columns"
import { type CategoriaTableData } from "../types/categoria.types"
import { useMemo } from "react"

export default function CategoriaTable({
  data,
  pageSize = 10,
  onSelect
}: {
  data: CategoriaTableData[],
  pageSize?: number,
  onSelect: (item: CategoriaTableData, modalType: string) => void
}) {
  const columns = useMemo(()=>{
    return CategoriaColumns({
      onSelect: (row: CategoriaTableData) => {
        onSelect(row, 'delete')
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
