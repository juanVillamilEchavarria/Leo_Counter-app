/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
