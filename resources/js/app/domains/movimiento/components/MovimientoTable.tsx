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
