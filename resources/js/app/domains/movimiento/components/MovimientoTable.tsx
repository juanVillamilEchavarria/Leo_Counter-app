import TanStackTable from "@/app/shared/components/table/advanced/TanStackTable"
import ShowMovimientoModal from "./ShowMovimientoModal"
import { router } from "@inertiajs/react"
import { useMemo, useState, useEffect } from "react"
import { BaseIcons } from "@/app/shared/types"
import { MovimientoColumns } from "./columns/movimiento.columns"
import { type MovimientoTableData, type MovimientoShowData, MovimientoRoutes } from "../types/movimiento.types"
import { ArchivoMovimientoRoutes } from "../../archivoMovimiento"
export default function MovimientoTable({
  data,
  onSelect

}:{
  data: MovimientoTableData[]
  onSelect : (item: MovimientoTableData) => void
}) {
   const columns = useMemo(()=>
    MovimientoColumns({
      onSelect
    })
   , [MovimientoColumns])
  return (
    <>
    <TanStackTable
           columns={columns}
           data={data}
            />
    </>
  )
}
