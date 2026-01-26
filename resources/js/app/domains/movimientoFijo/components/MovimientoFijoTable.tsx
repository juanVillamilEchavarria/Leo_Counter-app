import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import useMovimientoFijo from "../hooks/useMovimientoFijo"
import { MovimientoFijoColumns } from "./columns/movimientoFijo.columns"
import { useMemo, useState } from "react"
import { type MovimientoFijo, type MovimientoFijoTableData } from "../types/movimientoFijo.types"


export default function MovimientoFijoTable({
  data
}:{
  data: MovimientoFijoTableData[]
}) {

    const [movimientoFijoSelected, setMovimientoFijoSelected]= useState<MovimientoFijoTableData | null>(null)
    const columns = useMemo(()=>{
       return MovimientoFijoColumns({
            onDelete: (movimientoFijo: MovimientoFijoTableData)=>{
                setMovimientoFijoSelected(movimientoFijo)
            }
       })
     }, []) 
           const {form, handleSubmit}= useMovimientoFijo(
            {
              method:'delete',
             id: movimientoFijoSelected?.id
            })
    const handleDelete = (e: React.FormEvent<HTMLFormElement>)=>{
        if(!movimientoFijoSelected) return
        handleSubmit(e)
        setMovimientoFijoSelected(null)
    }
  return (
    <>
      <SimpleTable
          data={data}
          columns={columns}
          pagination={false}
        />
        <DeleteModal
            open={movimientoFijoSelected !== null}
            spanTitle="Eliminar"
            title='Movimiento Fijo'
            onClose={()=> setMovimientoFijoSelected(null)}
            paragraph={`¿Esta seguro de eliminar el Movimiento Fijo con ID: ${movimientoFijoSelected?.id} ?`}
            onSubmit={handleDelete}

        >
          <small>Los Movimientos fijos eliminados no se pueden recuperar, solo los movimientos fijos sin movimientos asociados pueden ser eliminados, si no lo usaras mas, mejor marcalo como inactivo</small>
          </DeleteModal >
    </>
  )
}
