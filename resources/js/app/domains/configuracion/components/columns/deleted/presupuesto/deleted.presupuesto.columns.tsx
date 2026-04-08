import { newColumns, type DeletedDomainColumnsProps } from "../utils/configuracion.deleted.columns.utils"
import { PresupuestoStaticColumns, type PresupuestoHistoricoTableData } from "@/app/domains/presupuestoHistorico"

export const deletedPresupuestoColumns = ({
    onSelect
}: DeletedDomainColumnsProps<PresupuestoHistoricoTableData>) => {
    return newColumns<PresupuestoHistoricoTableData>({
        onSelect: onSelect,
        columns: PresupuestoStaticColumns,
        columnsToRemove: [],
    })
}
