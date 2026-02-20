import { type ColumnDef } from "@tanstack/react-table"
import { type InertiaProps } from "@/app/shared/types/intertia/props"
import { moneyFormat, dateFormat, normalizePeriod } from "@/app/shared/helpers"
import { router } from "@inertiajs/react"

export const PresupuestoHistoricoRoutes = {
    index: () => '/'
}

export const PresupuestoHistoricoApiActions = {
    paginatedData: '/presupuestos/historicos'
}

export type PresupuestoHistoricoTableData = {
    id: number,
    user: string,
    categoria: string,
    monto: number,
    periodo: string | Date
}

export const ColumnsTablePresupuestoHistorico: ColumnDef<PresupuestoHistoricoTableData>[] = [
    {
        id: 'id',
        header: 'ID',
        accessorKey: 'id'
    },
    {
        id: 'categoria',
        header: 'Categoría',
        accessorKey: 'categoria'
    },
    {
        id: 'monto',
        header: 'Monto',
        accessorKey: 'monto',
        cell: ({ row }) => moneyFormat(Number(row.original.monto))
    },
    {
        id: 'user',
        header: 'Usuario',
        accessorKey: 'user'
    },
    {
        id: 'periodo',
        header: 'Periodo',
        accessorKey: 'periodo',
        cell: ({ row }) => dateFormat(normalizePeriod(row.original.periodo), 'MMM [de] YYYY')
    },
]

export type PresupuestoHistoricoProps = InertiaProps & {
    presupuestos: { data: PresupuestoHistoricoTableData[] }
}