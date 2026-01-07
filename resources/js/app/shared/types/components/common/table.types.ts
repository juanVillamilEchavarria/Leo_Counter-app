import { type ColumnDef, type Table } from "@tanstack/react-table"
export type EditAndDeleteActionsProps={
    editHref?: string,
    deleteOnClick?: () => void | undefined
}
export type TanStackTableProps={
        columns : ColumnDef<Record<string,any>>[]
        data : Record<string,any>[]
}
export type useTanStackTableProps= TanStackTableProps &{
        pageSize?: number
        maxVisible?:number
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
        pagination?: boolean
        pageSize?:number,
        controller?: TablePaginationController
}
export interface TablePaginationController {
  page: number
  totalPages: number
  canNext: boolean
  canPrev: boolean
  goTo: (page: number) => void
  next: () => void
  prev: () => void
}

export type TablePaginationProps={
         controller: TablePaginationController | undefined
         maxVisible?: number

}
