import { type ColumnDef, type Table } from "@tanstack/react-table"
export type EditAndDeleteActionsProps={
    editHref?: string,
    deleteOnClick?: () => void | undefined
}
export type SimpleTanStackTableProps={
        columns : ColumnDef<Record<string,any>>[]
        data : Record<string,any>[]
}
export type useTanStackTableProps= SimpleTanStackTableProps &{
        pageSize?: number
        maxVisible?:number
}

export type TablePaginationProps={
    table: Table<Record<string, any>>
        start: number 
        end: number
        visiblePages: number[]
        pageCurrentIndex: number
        totalPages: number
}
