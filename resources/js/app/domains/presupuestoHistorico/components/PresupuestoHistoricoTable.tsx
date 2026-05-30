/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import TanStackTableServerSide from "@/app/shared/components/table/advanced/TanStackTableServerSIde"
import { useMemo } from "react"
import { ColumnsTablePresupuestoHistorico, type PresupuestoHistoricoTableData, PresupuestoHistoricoApiActions } from "../types/presupuesto.types"

export default function PresupuestoHistoricoTable() {
    const columns = useMemo(() => ColumnsTablePresupuestoHistorico, [])

    return (
        <TanStackTableServerSide<PresupuestoHistoricoTableData>
            columns={columns}
            endpoint={PresupuestoHistoricoApiActions.paginatedData}
            queryKey={['presupuestos', 'historicos']}
            pageSize={10}
        />
    )
}
