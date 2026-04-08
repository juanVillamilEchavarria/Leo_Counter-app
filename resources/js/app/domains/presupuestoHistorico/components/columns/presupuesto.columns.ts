import type { SimpleTableColumn } from "@/app/shared/types/components"
import { moneyFormat, dateFormat, normalizePeriod } from "@/app/shared/helpers"
import type { PresupuestoHistoricoTableData } from "../../types/presupuesto.types"

export const PresupuestoStaticColumns: SimpleTableColumn<PresupuestoHistoricoTableData>[] = [
    {
        key: 'id',
        label: 'ID',
    },
    {
        key: 'categoria',
        label: 'Categoría',
    },
    {
        key: 'monto',
        label: 'Monto',
        render: (row: PresupuestoHistoricoTableData) => moneyFormat(Number(row.monto))
    },
    {
        key: 'user',
        label: 'Usuario',
    },
    {
        key: 'periodo',
        label: 'Periodo',
        render: (row: PresupuestoHistoricoTableData) => dateFormat(normalizePeriod(row.periodo), 'MMM [de] YYYY')
    },
]
