import Button from "../common/Button"
import { getCoreRowModel, useReactTable, flexRender, getPaginationRowModel } from "@tanstack/react-table"
import {useMemo } from "react"
import dataMock from '../../../../../../MOCK_DATA.json' 
import { getVisiblePages } from "../../helpers"
export default function SimpleTanStackTable() {
    const data= useMemo(
        () => dataMock,[])
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
        initialState: {
            pagination: {
                pageSize: 10,
            },
        },
        getCoreRowModel: getCoreRowModel(),
        getPaginationRowModel: getPaginationRowModel(),
    })
    const pageCurrentIndex= table.getState().pagination.pageIndex
    const totalPages= table.getPageCount()
    const {pages: visiblePages, start, end}= getVisiblePages(pageCurrentIndex, totalPages, 5)
    console.log(table.getHeaderGroups())
    

  return (
    <div className="">
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
    <div className=" w-[80%] my-4 flex justify-start">
        <ul className="w-1/4 flex rounded-2xl">
         <li className="mr-3">
            <Button variant="primaryPagination" onClick={()=> table.setPageIndex(0)} className="rounded-none">Primer</Button>
        </li>
        <div className="flex ">
            <li className="">
                <Button variant="primaryPagination" onClick={()=> table.previousPage()} className="rounded-none px-3 "><i className="fa-regular fa-circle-left "></i></Button>
            </li>
            {start > 0 && <li className="">
                <Button variant="primaryPagination" className="rounded-none px-3 ">...</Button>
                </li>
            }
            {visiblePages.map((index) => (
                <li key={index} className="">
                    <Button variant="primaryPagination" onClick={()=> table.setPageIndex(index)} className={`rounded-none px-5 ${index === pageCurrentIndex ? 'border-cyan-500! text-cyan-400!' : ''}`}>{index + 1}</Button>
                </li>
            ))}

            {end < totalPages - 1 && <li className="">
                <Button variant="primaryPagination" className="rounded-none px-3 ">...</Button>
                </li>
            }
            <li className="">
                <Button variant="primaryPagination" onClick={()=> table.nextPage()} className="rounded-none px-3 "><i className="fa-regular fa-circle-right "></i></Button>
            </li>

        </div>
       
            
             <li className="mr-3">
            <Button variant="primaryPagination" onClick={()=> table.setPageIndex(totalPages - 1)} className="rounded-none">Ultimo</Button>
        </li>
        </ul>
    </div>
    </div>
    
  )
}
