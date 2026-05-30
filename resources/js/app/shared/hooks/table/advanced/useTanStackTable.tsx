/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { getCoreRowModel,
     useReactTable,
     getPaginationRowModel,
     getSortedRowModel,
     getFilteredRowModel,
     type SortingState,

} from "@tanstack/react-table"
// hooks 
import {
    useMemo, 
    useState,
    type JSX
} from "react"
import { type useTanStackTableProps } from "../../../types/components"



// hook de tanstackTable
export default function useTanStackTable<T = Record<string,any>>({
    columns,
    data,
    pageSize = 10, //La cantidad de registros visibles por pagina
    maxVisible= 5 // la cantidad de numeros de paginacion visibles
}:useTanStackTableProps<T>) {

        // state para manejar el sorting ( filtrar columna por orden)
        const[sorting, setSorting]= useState<SortingState>([])

        // state apara manejar la busqueda 
        const [filtering, setFiltering]= useState('')

        // se crea el react/tanstack table
        const table = useReactTable({
            data,
            columns,
            initialState: {
                pagination: {
                    pageSize: pageSize,
                },
            },
            getCoreRowModel: getCoreRowModel(),
            getPaginationRowModel: getPaginationRowModel(),
            getSortedRowModel: getSortedRowModel(),
            state:{
                sorting,
                globalFilter: filtering
            },
            onGlobalFilterChange: setFiltering,
            onSortingChange: setSorting,
            getFilteredRowModel: getFilteredRowModel()
        })

        
        const pageCurrentIndex= table.getState().pagination.pageIndex // la pagina actual

        const totalPages= table.getPageCount() // el total de paginas que hay en la tabla

       

        const UpDown = useMemo<Record<'asc' | 'desc', JSX.Element>>(() => ({ // Iconos para el sorting
            asc: <i className="fa-solid fa-caret-up" />,
            desc: <i className="fa-solid fa-caret-down" />,
        }), [])
  return {
    sorting,
    filtering,
    table,
    pageCurrentIndex,
    totalPages,
    UpDown,
    setFiltering,
    setSorting
  }
}
