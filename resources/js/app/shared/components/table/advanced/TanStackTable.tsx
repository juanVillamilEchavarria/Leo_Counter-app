import InputFillable from "../../form/InputFillable"
import TablePagination from "../pagination/TablePagination"
import { flexRender} from "@tanstack/react-table"
import useTanStackTable from "../../../hooks/table/advanced/useTanStackTable"
import { useTanStackPagination } from "@/app/shared/hooks"
import { type ChangeEvent, useMemo } from "react"
import { type TanStackTableProps } from "../../../types/components" 
export default function TanStackTable({
    columns,
    data
}:TanStackTableProps) {
    if(columns === undefined|| data=== undefined)return null
    const {
        filtering,
        setFiltering,
        table, 
        pageCurrentIndex,
        totalPages,
        UpDown
    }= useTanStackTable({
        columns,
        data
    }) 
    const controller =useTanStackPagination(table)
 
  return (
    <div>
        <div className="flex w-full my-2 justify-start">
            <InputFillable 
                type="text" 
                icon="fa-solid fa-search"
                value={filtering}
                placeholder="Busqueda"
                className="border border-azul-oscuro/50 rounded-2xl transition-all "
                onChange={(e: ChangeEvent<HTMLInputElement>)=> setFiltering(e.target.value)}
            />
        </div>
        <div className="table-container">
        <table className="table-general">
            <thead className="table-thead">
                {table.getHeaderGroups().map((headerGroup) => (
                    <tr key={headerGroup.id}>
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
                {table.getRowModel().rows.map((row) => (
                    <tr key={row.id}>
                        {row.getVisibleCells().map((cell) => (
                            <td key={cell.id}>
                                {flexRender(cell.column.columnDef.cell, cell.getContext())}
                            </td>
                        ))}
                    </tr>
                ))}
              
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
