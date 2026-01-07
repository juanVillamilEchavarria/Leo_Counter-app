import { type ColumnDef } from "@tanstack/react-table"
export const ColumnsTableMovimientos: ColumnDef<Record<string,any>>[]=[
    {
        id: 'id',
        header: 'ID',
        accessorKey: 'id'
    },
    {
        id: 'name',
        header: 'name',
        accessorKey: 'name'
    },
    {
        id:'email',
        header: 'email',
        accessorKey: 'email'
    }
]