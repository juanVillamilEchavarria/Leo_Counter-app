import TablePagination from "../pagination/TablePagination"
import TableEntries from "../pagination/TableEntries"
import { type SimpleTableProps } from "../../../types/components"
import { useEntries } from "@/app/shared/hooks"
import {useSimpleTable }from "@/app/shared/hooks"
/**
 * Componente de tabla client side, con paginacion
 * @param {SimpleTableColumn[]} columns - Columnas de la tabla
 * @param {T[]} data - Datos de la tabla
 * @param {string} emptyMessage - Mensaje de vacio
 * @param {boolean} pagination - Mostrar paginacion
 * @param {number} pageSize - Tamaño de la paginacion
 * @returns  {JSX.Element}
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @package shared/components/table
 */
export default function SimpleTable<T>({
    columns,
    data,
    emptyMessage= "No hay registros",
    pagination=true,
    pageSize=10,
}: SimpleTableProps<T>) {
    const {entries, setEntries} = useEntries({
        value: pageSize
    })
    const {data: paginatedData, pagination: controller}  = useSimpleTable({
        data,
        pageSize: entries,
       })
  return (
    <div>
         <div className="overflow-x-auto w-full table-container">
            <table className="table-general min-w-[640px]">
                <thead className="table-thead">
                    <tr>
                        {columns.map((col)=>(
                            <th key={String(col.key)} className={col.className}>
                                {col.label}
                            </th>
                        ))}
                       
                    </tr>
                </thead>
                <tbody className="table-tbody">
                    {paginatedData.length===0 &&(
                        <tr>  
                            <td colSpan={columns.length} className="text-muted-foreground  text-xl text-center">
                                {emptyMessage}
                             </td>  
                        </tr>
                    )}
                    {paginatedData.map((row, i)=>
                       (
                            <tr key={i} className="text-foreground">  
                            {columns.map(col=>{
                                return(
                                    <td key={String(col.key)} className={col.className}>
                                        {col.render // si hay un render de algun componente, lo mostramos en la tabla 
                                         ? col.render(row) 
                                         // si no hay render, mostramos el string del registro en su posicion de la columna
                                         : row[col.key as keyof T] !== null ? String(row[col.key as keyof T]): <span className="text-muted-foreground uppercase">Campo Vacio</span> // sino mostramos el string del registro en su posicion de la columna
                                         }
                                    </td>

                                )
                            })}
                        </tr>
                        )
                    )}
                  
                </tbody>
            </table>
            
        </div>
        {pagination&&(
                 <div className="mt-10 w-full flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <TablePagination
                        controller={controller}        
                        />
                        <TableEntries
                        entries={entries}
                        setEntries={setEntries} />
                    </div>
            )}
    </div>
   
  )
}
