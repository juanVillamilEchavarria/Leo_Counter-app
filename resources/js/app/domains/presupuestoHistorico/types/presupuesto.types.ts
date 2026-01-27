import { type ColumnDef } from "@tanstack/react-table"
import { type InertiaProps } from "@/app/shared/types/intertia/props"
import { dateFormat } from "@/app/shared/helpers"

export const ColumnsTablePresupuestoHistorico: ColumnDef<PresupuestoHistoricoTableData>[]=[
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
        id: 'tipo_presupuesto',
        header: 'Tipo',
        accessorKey: 'tipo_presupuesto'
    },
    {
        id: 'monto',
        header: 'Monto',
        accessorKey: 'monto',
        cell: ({ row }) => {
            return new Intl.NumberFormat('es-ES', {
                style: 'currency',
                currency: 'COP',
            }).format(row.original.monto)
        }
    },
    {
        id: 'usuario',
        header: 'Usuario',
        accessorKey: 'user'
    },
    {
        id: 'fecha_inicio',
        header: 'Fecha Inicio',
        accessorKey: 'fecha_inicio',
        cell: ({ row }) => {
            return dateFormat(row.original.fecha_inicio)
        }
    },
    {
        id: 'fecha_final',
        header: 'Fecha Final',
        accessorKey: 'fecha_final',
        cell: ({ row }) => {
            return dateFormat(row.original.fecha_final)
        }
    }
]

export type PresupuestoHistoricoTableData = {
    id: number,
    user: string,
    categoria: string,
    tipo_presupuesto: string,
    monto: number,
    fecha_inicio: string | Date,
    fecha_final: string | Date
}

export type PresupuestoHistoricoProps = InertiaProps & {
    presupuestos: { data:PresupuestoHistoricoTableData[]}
}