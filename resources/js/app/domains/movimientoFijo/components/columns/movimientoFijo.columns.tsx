import ModelToggle from "@/app/shared/components/table/actions/ModelToggle"
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import { MovimientoFijoActions, MovimientoFijoRoutes } from "../../types/movimientoFijo.types"
import { dateFormat } from "@/app/shared/helpers"
import { type MovimientoFijoTableData } from "../../types/movimientoFijo.types"
export const MovimientoFijoColumns = (({
    onDelete
}:{
    onDelete: (movimientoFijo: MovimientoFijoTableData)=>void
}) => {
    return [
           { key: "id", label: "ID" },
           {key: "nombre", label : "Nombre"},
           { key: "cuenta", label: "Cuenta" },
           { key: "tipo_movimiento", label: "Tipo" },
           { key: "categoria", label: "Categoria" },
           { key: "monto", label: "Monto" },
           { key: "fecha_proximo", label: "Fecha Del Proximo Pago", render: (row: MovimientoFijoTableData)=>(dateFormat(row.fecha_proximo)) },
           { key: "frecuencia_movimiento", label: "Frecuencia" },
           { key: "descripcion", label: "Descripcion", className: 'w-30' },
           {
             key: 'active',
             label: 'Activo',
             render: (row : MovimientoFijoTableData)=>(
               <ModelToggle 
               active={row.active}
               route={MovimientoFijoActions.toggleActive(row.id)}
               />
             )
           },
            {
             key: 'registrar_automatico',
             label: 'Registro Automatico',
             render: (row : MovimientoFijoTableData)=>(
                <ModelToggle 
                active={row.registrar_automatico}
                route={MovimientoFijoActions.toggleRegistrarAutomaticamente(row.id)}
                labels={{
                    active: 'Automatico',
                    inactive: 'No Automatico'
                }}
                />

             )
           },
           {
             key: 'actions',
             label: '',
             render: (row : MovimientoFijoTableData)=>(
               <EditAndDeleteActions
                    editHref={MovimientoFijoRoutes.edit(row.id)}
                    deleteOnClick={()=> onDelete(row)}
                />
             )
           }
         ]
})
