import Search from "../actions/Search"
import TablePagination from "../pagination/TablePagination"
import { flexRender} from "@tanstack/react-table"
import useTanStackTable from "../../../hooks/table/advanced/useTanStackTable"
import { useTanStackPagination } from "@/app/shared/hooks"
import { type TanStackTableProps } from "../../../types/components" 
export default function TanStackTable<T extends Record<string,any>>({
    columns,
    data,

}:TanStackTableProps<T>) {
    if(columns === undefined|| data=== undefined)return null
    const {
        filtering,
        setFiltering,
        table, 
        UpDown
    }= useTanStackTable<T>({
        columns,
        data
    }) 
    const controller =useTanStackPagination(table)
 
  return (
    <div>
        <Search value={filtering} setValue={setFiltering} />
        <div className="table-container">
        <table className="table-general">
            <thead className="table-thead">
                {table.getHeaderGroups().map((headerGroup) => (
                    <tr  key={headerGroup.id} >
                        {headerGroup.headers.map((header) => {
                            // variable para saber si se esta filtrando la columna de menor a mayor 
                            const isSorted = header.column.getIsSorted()
                            return (
                            <th key={header.id}
                            // cuando se le de click, se va a filtrar en orden, asi como datatable
                              onClick={header.column.getToggleSortingHandler()}
                            >
                                <div className="flex justify-start text-left gap-1 cursor-pointer">
                                {
                                    // este es el header, el texto 
                                    flexRender(
                                        header.column.columnDef.header,
                                        header.getContext())
                               }
                               {
                                // dependiendo de lo que haya, se muestra el icono correspondiente
                                 isSorted!==false && UpDown[isSorted]
                               }
                                </div>
                               
                            </th>
                        )})}
                    </tr>
                ))}
            </thead>
            <tbody className="table-tbody">
                {table.getRowModel().rows.length>0 ? table.getRowModel().rows.map((row) => (
                    <tr 
                    key={row.id} 

                    >
                        {row.getVisibleCells().map((cell) => (
                            <td key={cell.id}>
                                {cell.getValue()!== null ?flexRender(cell.column.columnDef.cell, cell.getContext()): <span className="text-muted-foreground">CAMPO VACIO</span>}
                            </td>
                        ))}
                    </tr>
                )):(
                    <tr>
                        <td colSpan={columns.length} className="text-muted-foreground  text-xl text-center">
                            No hay registros
                        </td>
                    </tr>
                )}
              
            </tbody>
        </table>
    </div>
    <div className=" w-[80%] my-4 flex justify-start">
        <TablePagination
        controller={controller}        
        />
    </div>

    </div>
    
  )
}
