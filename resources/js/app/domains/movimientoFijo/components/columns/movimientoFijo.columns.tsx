/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import ModelToggle from "@/app/shared/components/table/actions/ModelToggle"
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import SuccessOrFailText from "@/app/shared/components/common/SuccessOrFailText"
import { MovimientoFijoActions, MovimientoFijoRoutes,  MovimientoFijoToggleTypes } from "../../types/movimientoFijo.types"
import { dateFormat } from "@/app/shared/helpers"
import { moneyFormat } from "@/app/shared/helpers"
import { type MovimientoFijoTableData } from "../../types/movimientoFijo.types"
export const MovimientoFijoColumns = (({
    onSelect
}:{
    onSelect: (movimientoFijo: MovimientoFijoTableData)=>void
}) => {
    return [
           { key: "id", label: "ID" },
           {key: "nombre", label : "Nombre"},
           { key: "cuenta", label: "Cuenta" },
           { key: "tipo_movimiento", label: "Tipo",
            render : (row : MovimientoFijoTableData)=>(
                   <SuccessOrFailText
                       attribute={row.tipo_movimiento}
                       value="Ingreso"
                     />
            )
            },
           { key: "categoria", label: "Categoria" },
           { key: "monto", label: "Monto", render: (row: MovimientoFijoTableData)=>(moneyFormat(Number(row.monto))) },
           { key: "fecha_proximo", label: "Fecha Del Proximo Pago", render: (row: MovimientoFijoTableData)=>(dateFormat(row.fecha_proximo)) },
           { key: "frecuencia_movimiento", label: "Frecuencia" },
           { key: "descripcion", label: "Descripcion", className: 'max-w-50 truncate' },
           {
             key: 'active',
             label: 'Activo',
             render: (row : MovimientoFijoTableData)=>(
               <ModelToggle
               active={row.active}
               route={MovimientoFijoActions.toggle(row.id, MovimientoFijoToggleTypes.active  )}
               />
             )
           },
            {
             key: 'registrar_automatico',
             label: 'Registro Automatico',
             render: (row : MovimientoFijoTableData)=>(
                <ModelToggle
                active={row.registrar_automatico}
                route={MovimientoFijoActions.toggle(row.id, MovimientoFijoToggleTypes.registrar_automatico )}
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
                    deleteOnClick={()=> onSelect(row)}
                />
             )
           }
         ]
})
