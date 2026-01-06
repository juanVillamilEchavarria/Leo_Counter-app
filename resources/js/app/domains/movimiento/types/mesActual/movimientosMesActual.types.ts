import { type ColumnDef } from "@tanstack/react-table"
export const ColumnsTableMovimientosMesActual: ColumnDef<Record<string,any>>[]=[
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
export type MovimientosMesActualProps = {
    inicio: string
    fin: string
}