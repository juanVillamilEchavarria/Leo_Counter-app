import TablePagination from "../pagination/TablePagination"
import TableEntries from "../pagination/TableEntries"
import { type SimpleTableProps } from "../../../types/components"
import { useEntries } from "@/app/shared/hooks"
import {useSimpleTable }from "@/app/shared/hooks"

export default function SimpleTable<T>({ //en el T se le pasa el tipo de Modelo para tiparlo correctamente
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
         <div className="table-container min-w-200">
            <table className="table-general">
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
                            <tr key={i}>  
                            {columns.map(col=>{
                                return(
                                    <td key={String(col.key)} className={col.className}>
                                        {col.render // si hay un render de algun componente, lo mostramos en la tabla 
                                         ? col.render(row) 
                                         // si no hay render, mostramos el string del registro en su posicion de la columna
                                         : row[col.key as keyof T] !== null ? String(row[col.key as keyof T]): <span className="text-gray-400 uppercase">Campo Vacio</span> // sino mostramos el string del registro en su posicion de la columna
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
                 <div className=" mt-10 w-full flex justify-between">
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
