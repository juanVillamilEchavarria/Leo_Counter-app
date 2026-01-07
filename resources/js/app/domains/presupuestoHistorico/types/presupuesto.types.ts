import { type ColumnDef } from "@tanstack/react-table"
export const ColumnsTablePresupuestoHistorico: ColumnDef<Record<string,any>>[]=[
    {
        id: 'id',
        header: 'ID',
        accessorKey: 'id'
    },
    {
        id: 'nombre',
        header: 'nombre',
        accessorKey: 'nombre'
    }
]
export type PresupuestoHistoricoTableData = {
    id: number,
    user: string,
    categoria: string,
    monto: number,
    periodo: string| Date
}