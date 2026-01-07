import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import ToggleState from "@/app/shared/components/table/ToggleState"
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import { useMemo, useState } from "react"
import { type MovimientoFIjoTableData } from "../types/movimientoFijo.types"


export default function MovimientoFijoTable() {
    const data: MovimientoFIjoTableData[]=[
         {
      id: 1,
      user: "Juan",
      cuenta: 'cuenta 2',
      tipo: 'Fijo',
      categoria: "Alimentacion",
      monto: 200,
      fecha: '2-12-2025',
      frecuencia: 'semanal',
      descripcion: 'es del mercado',
      active: true,
      registrar_automatico: true
    },
       
    ]
    const [active, setActive]= useState(false)
    const columns = useMemo(()=>{
       return [
       { key: "id", label: "ID" },
       { key: "user", label: "User" },
       { key: "cuenta", label: "Cuenta" },
       { key: "tipo", label: "Tipo" },
       { key: "categoria", label: "Categoria" },
       { key: "monto", label: "Monto" },
       { key: "fecha", label: "Fecha" },
       { key: "frecuencia", label: "Frecuencia" },
       { key: "descripcion", label: "Descripcion", className: 'w-30' },
       {
         key: 'active',
         label: 'Activo',
         render: (row : MovimientoFIjoTableData)=>(
           <ToggleState 
           active={row.active}
           setActive={setActive}
           />
         )
       },
        {
         key: 'registrar_automatico',
         label: 'Registro Automatico',
         render: (row : MovimientoFIjoTableData)=>(
           <ToggleState 
           active={row.registrar_automatico}
           setActive={setActive}
           />
         )
       },
       {
         key: 'actions',
         label: '',
         render: ()=>(
           <EditAndDeleteActions />
         )
       }
     ]
     }, []) 
  return (
   <SimpleTable
       data={data}
       columns={columns}
       pagination={false}
    />
  )
}
