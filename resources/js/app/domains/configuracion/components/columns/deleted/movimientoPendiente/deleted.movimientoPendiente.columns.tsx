import { newColumns, type DeletedDomainColumnsProps } from "../utils/configuracion.deleted.columns.utils"
import { MovimientoPendienteStaticColumns, type MovimientoPendienteTableData } from "@/app/domains/movimientoPendiente"

export const deletedMovimientoPendienteColumns = ({
    onSelect
}: DeletedDomainColumnsProps<MovimientoPendienteTableData>) => {
    return newColumns<MovimientoPendienteTableData>({
        onSelect: onSelect,
        columns: MovimientoPendienteStaticColumns,
        columnsToRemove: ['movimiento_fijo', 'enough_balance'],
    })
}
