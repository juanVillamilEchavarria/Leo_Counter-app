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
