/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import ActionSection from "@/app/shared/components/table/actions/ActionSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SuccessOrFailText from "@/app/shared/components/common/SuccessOrFailText"
import MoneyFlow from "@/app/shared/components/common/MoneyFlow"
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
            key: 'categoria',
            label: 'Categoria'
        },
        {
            key: 'tipo_movimiento',
            label: 'Tipo',
            render: (row: MovimientoEspontaneoTableData) => (
                <SuccessOrFailText attribute={row.tipo_movimiento} value={'Ingreso'}  />
            )
        },
  
        {
            key: 'monto',
            label: 'Monto',
            render: (row: MovimientoEspontaneoTableData) => (
                <MoneyFlow monto={row.monto} tipo_movimiento={row.tipo_movimiento} />
            )
        },
        {
            key: 'descripcion',
            label: 'Descripcion'
        },
        {
            key : 'actions',
            label : '',
            render: (row: MovimientoEspontaneoTableData) => (
                <ActionSection
                    as={CrudButton}
                    actions={[
                        { onClick: () => onSelect(row, 'delete'), Crudvariant: 'Delete' }
                    ]}
                />
            )
        }


    ]
}