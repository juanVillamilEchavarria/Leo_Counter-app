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

export type SimpleTableColumn <T>={
        key: keyof T | string
        label: string
        className?: string
        render?: (row : T)=> React.ReactNode //se le pasa un posible componente, como botones, switches, etc
}

export type SimpleTableProps<T>={
        columns: SimpleTableColumn<T>[]
        data: T[]
        emptyMessage?:string
}
