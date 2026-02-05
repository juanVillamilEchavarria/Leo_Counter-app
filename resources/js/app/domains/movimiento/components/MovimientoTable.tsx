import TanStackTable from "@/app/shared/components/table/advanced/TanStackTable"
import ShowModal from "@/app/shared/components/modal/ShowModal"
import MovimientoShowModal from "./MovimientoShowModal"
import { router } from "@inertiajs/react"
import { useMemo, useState, useEffect } from "react"
import { BaseIcons } from "@/app/shared/types"
import { MovimientoColumns } from "./columns/movimiento.columns"
import { type MovimientoTableData, type MovimientoShowData, MovimientoRoutes } from "../types/movimiento.types"
import { ArchivoMovimientoRoutes } from "../../archivoMovimiento"
export default function MovimientoTable({
  data,
  showData
}:{
  data: MovimientoTableData[]
  showData?: MovimientoShowData
}) {
  const [itemSelected, setItemSelected] = useState<MovimientoShowData | null>(null)
  useEffect(() => {
    if (showData) {
      setItemSelected(showData)
    }
  }, [showData])
   const columns = useMemo(()=>
    MovimientoColumns({
      onSelect: (item: MovimientoTableData) => {
        router.get(MovimientoRoutes.show(item.id),{},{
          preserveState: true,
          preserveScroll: true
        })
      }
    })
   , [MovimientoColumns])
  return (
    <>
    <TanStackTable
           columns={columns}
           data={data}
            />
    <MovimientoShowModal 
    movimiento={itemSelected}
    onClose={()=>{
              setItemSelected(null)
              router.get(MovimientoRoutes.index,{},{
                preserveState: true,
                preserveScroll: true
              })
            }}
    />
    </>
  )
}
