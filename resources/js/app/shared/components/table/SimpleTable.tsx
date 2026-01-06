import { td, th } from "framer-motion/client"
import { type SimpleTableProps } from "../../types/components"

export default function SimpleTable<T>({
    columns,
    data,
    emptyMessage= "No hay registros"
}: SimpleTableProps<T>) {
  return (
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
                            <td colSpan={columns.length} className="text-gray-500 font-bold text-xl">
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
                                         : String((row as any)[col.key]) // sino mostramos el string del registro en su posicion de la columna
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
  )
}
