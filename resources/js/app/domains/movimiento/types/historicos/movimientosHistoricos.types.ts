import { type ColumnDef } from "@tanstack/react-table"
export const ColumnsTableMovimientosHistoricos: ColumnDef<Record<string,any>>[]=[
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