import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import { type MovimientoEspontaneoTableData, MovimientoEspontaneoRoutes } from "../../types/movimientoEspontaneo.types"

export const MovimientoEspontaneoColumns = ({
    onSelect
}:{
    onSelect : (row: MovimientoEspontaneoTableData, modalType: string) => void
})=>{
    return [
        {
            key: 'id',
            label: 'ID'
        },
        {
            key: 'nombre',
            label: 'Nombre'
        },
        {
            key: 'cuenta',
            label: 'Cuenta'
        },
        {
            key: 'tipo_movimiento',
            label: 'Tipo'
        },
        {
            key: 'monto',
            label: 'Monto'
        },
        {
            key: 'descripcion',
            label: 'Descripcion'
        },
        {
            key : 'actions',
            label : '',
            render: (row: MovimientoEspontaneoTableData) => (
                <EditAndDeleteActions
                    editHref={MovimientoEspontaneoRoutes.edit(row.id)}
                    deleteOnClick={() => onSelect(row, 'delete')}
                />
            )
        }


    ]
}