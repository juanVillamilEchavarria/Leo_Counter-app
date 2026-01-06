import { getCoreRowModel, useReactTable, flexRender } from "@tanstack/react-table"
import { use, useMemo } from "react"
export default function SimpleTanStackTable() {
    const data= useMemo(
        () => [
            {
                id: "tanner",
                name: "Tanner",
                email: "n2p9o@example.com",
            },
            {
                id: "brett",
                name: "Brett",
                email: "HtJ3L@example.com",
            }
    ],[])
    const columns= useMemo(
        ()=>[
            {
                
                header: "ID",
                accessorKey: "id",
                cell: info => info.getValue(),
    
            },
            {

            header: "Name",
            accessorKey: "name",
            cell: info => info.getValue(),
        },
        {
            header: "Email",
            accessorKey: "email",
            cell: info => info.getValue()

        }
    ],[])
    const table = useReactTable({
        data,
        columns,
        getCoreRowModel: getCoreRowModel(),
    })
    console.log(table.getHeaderGroups())
    

  return (
    <div className="table-container">
        <table className="table-general">
            <thead className="table-thead">
                {table.getHeaderGroups().map((headerGroup) => (
                    <tr key={headerGroup.id}>
                        {headerGroup.headers.map((header) => (
                            <th key={header.id}>
                               {flexRender(header.column.columnDef.header, header.getContext())}
                            </th>
                        ))}
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
  )
}
