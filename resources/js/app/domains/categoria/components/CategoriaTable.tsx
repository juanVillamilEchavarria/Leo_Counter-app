import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import ToggleState from "@/app/shared/components/table/ToggleState"
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import { useMemo, useState } from "react"
import { type CategoriaTableData } from "../types/categoria.types"
export default function CategoriaTable() {
    const [active, setActive]= useState(false)
    const data : CategoriaTableData[]=[
    ]
      const columns = useMemo(()=>{
           return [
           { key: "id", label: "ID" },
           { key: "nombre", label: "Nombre" },
           { key: "tipo", label: "Tipo" },
           { key: "tipo", label: "Tipo" },
           { key: "descripcion", label: "Descripcion", className: 'w-30' },
           {
             key: 'esFijo',
             label: 'Es Fijo',
             render: (row : CategoriaTableData)=>(
               <ToggleState 
               active={row.esFijo}
               setActive={setActive}
               message={{
                active: 'Fijo',
                inactive: 'No Fijo'
               }}
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
       
        />
  )
}
