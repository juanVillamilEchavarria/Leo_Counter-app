import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import usePropietario from "../hooks/usePropietario"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import { useMemo , useState} from "react"
import { PropietarioColumns } from "./columns/propietarios.columns"
import { type Propietario } from "../types/propietario.types"
export default function PropietarioTable({
    pageSize=10,
    data
}:{
    pageSize?: number,
    data: Propietario[]
}) {
    const [propietarioSelected, setPropietarioSelected]= useState<Propietario|null>(null)
    const columns= useMemo(()=>{
        return PropietarioColumns({
            onDelete: (propietario: Propietario)=>{
                setPropietarioSelected(propietario)
            }
        })
    },[])
    const {form, handleSubmit }=usePropietario({
        method: 'delete',
        id: propietarioSelected?.id
    })
     const handleDelete = (e: React.FormEvent<HTMLFormElement>) => {
    if (!propietarioSelected) return  // si no hay cuenta seleccionada, no hacemos nada
    handleSubmit(e)
    setPropietarioSelected(null)
  }
  return (
    <>
    <SimpleTable 
    data={data }
    columns={columns}
    pagination={false}
    />
     <DeleteModal
          open={propietarioSelected !== null}
          onClose={() => setPropietarioSelected(null)}
           onSubmit={handleDelete}
          spanTitle={'Eliminar'}
          title={' Propietario'}
          paragraph={`¿Esta seguro de eliminar el propietario: ${propietarioSelected?.nombre} ?`}
          >
            <small>los propietarios eliminados no son recuperables</small>
          </DeleteModal>
    </>
  )
}
