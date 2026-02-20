import { type ColumnDef, type PaginationState, type SortingState } from "@tanstack/react-table"
export type EditAndDeleteActionsProps={
    editHref?: string,
    deleteOnClick?: () => void | undefined
    editIcon?: string
    deleteIcon?: string
}
export type TanStackTableProps<T = Record<string,any>>={
        columns : ColumnDef<T>[]
        data : T[]
}
export type useTanStackTableProps<T = Record<string,any>>= TanStackTableProps<T> &{
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

export type useModelToggleProps={
    route: string
    payload?: Record<string, any>
    options?: {
        onSuccess?: () => void
        onError?: () => void
    }
}


export type ModelToggleProps = {
  active: boolean
  route: string
  payload?: Record<string, any>
  labels?: {
    active?: string
    inactive?: string
  }
}
export interface ServerSideTableParams {
    pagination: PaginationState;
    sorting: SortingState;
    globalFilter: string;
}

export type ServerSideTableResponse <T>={
    data: T[];
    meta: {
        currentPage: number;
        perPage: number;
        total: number;
        lastPage: number;
        from: number;
        to: number;
    };
}

export interface UseServerSideTableProps {
    endpoint: string;
    queryKey: string[];
    params: ServerSideTableParams;
    enabled?: boolean;
}
export type UseServerSideTanStackTableProps<T extends Record<string, any>>={
    columns: ColumnDef<T, any>[];
    endpoint: string
    queryKey: string[]
    initialPageSize?: number
}
