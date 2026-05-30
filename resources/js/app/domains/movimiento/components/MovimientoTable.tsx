/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import TanStackTableServerSide from "@/app/shared/components/table/advanced/TanStackTableServerSIde"
import { useMemo } from "react"
import { MovimientoColumns } from "./columns/movimiento.columns"
import { type MovimientoTableData, MovimientoApiActions} from "../types/movimiento.types"

export default function MovimientoTable({
  onSelect

}:{
  onSelect : (item: MovimientoTableData) => void
}) {
   const columns = useMemo(()=>
    MovimientoColumns({
      onSelect
    })
   , [MovimientoColumns])
  return (
    <>
        <TanStackTableServerSide<MovimientoTableData>
            columns={columns}
            endpoint={MovimientoApiActions.paginatedData}
            queryKey={['movimientos', 'historicos']}
            pageSize={10}
        />
    </>
  )
}
