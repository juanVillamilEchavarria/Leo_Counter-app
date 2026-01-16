import TablePagination from "../pagination/TablePagination"
import { type SimpleTableProps } from "../../../types/components"
import { span } from "framer-motion/client"

export default function SimpleTable<T>({ //en el T se le pasa el tipo de Modelo para tiparlo correctamente
    columns,
    data,
    emptyMessage= "No hay registros",
    pagination=true,
    pageSize=10,
    controller
}: SimpleTableProps<T>) {
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
                    {data.length===0 &&(
                        <tr>  
                            <td colSpan={columns.length} className="text-gray-500  text-xl text-center">
                                {emptyMessage}
                             </td>  
                        </tr>
                    )}
                    {data.map((row, i)=>
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
                 <div className=" w-[80%] my-4 flex justify-start">
                        <TablePagination
                        controller={controller}        
                        />
                    </div>
            )}
    </div>
   
  )
}
