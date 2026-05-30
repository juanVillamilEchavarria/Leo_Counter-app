/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
