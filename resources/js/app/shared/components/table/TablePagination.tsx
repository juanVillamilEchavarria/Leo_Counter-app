import Button from "../common/Button"
import { type TablePaginationProps } from "../../types/components"

// el elemento padre define donde se coloca la paginacion
export default function TablePagination({
    table,
    start,
    end,
    visiblePages,
    pageCurrentIndex,
    totalPages
}:TablePaginationProps) {
   const disabledNext = !table.getCanNextPage()
const disabledBack = !table.getCanPreviousPage()
  return (
    
            <ul className="w-1/4 flex rounded-2xl">
                <li className="mr-3">
                    <Button 
                        variant="primaryPagination" 
                        onClick={()=> table.setPageIndex(0)} 
                        className="rounded-none"
                    >
                        Primer

                    </Button>
                </li>
                <div className="flex ">
                    <li className="">
                        <Button 
                            variant="primaryPagination" 
                            disabled={disabledBack}
                            onClick={()=> table.previousPage()} 
                            className={`rounded-none px-3 ${disabledBack && 'cursor-not-allowed! text-gray-500!'}`}
                            >
                            <i className="fa-regular fa-circle-left "></i>
                        </Button>
                    </li>
                    {start > 0 && <li className="">
                        <Button 
                            variant="primaryPagination" 
                            className="rounded-none px-3 "
                            >
                            ...

                            </Button>
                        </li>
                    }
                    {visiblePages.map((index) => (
                        <li key={index} className="">
                            <Button 
                                variant="primaryPagination" 
                                onClick={()=> table.setPageIndex(index)} 
                                className={`
                                    rounded-none 
                                    px-5 
                                    ${index === pageCurrentIndex ?
                                    'border-cyan-500! text-cyan-400!' 
                                    : ''}
                            `}>
                                {index + 1}

                            </Button>
                        </li>
                    ))}
        
                    {end < totalPages - 1 && <li className="">
                        <Button 
                            variant="primaryPagination" 
                            className="rounded-none px-3 "
                        >
                            ...

                        </Button>
                        </li>
                    }
                    <li className="">
                        <Button 
                            variant="primaryPagination" 
                            disabled={end>=totalPages-1}
                            onClick={()=> table.nextPage()} 
                            className={`rounded-none px-3 ${disabledNext && 'cursor-not-allowed! text-gray-500!'}`}
                            
                        >
                            <i className="fa-regular fa-circle-right "></i>
                        </Button>
                    </li>
        
                </div>
            
                    
                    <li className="mr-3">
                    <Button 
                        variant="primaryPagination" 
                        onClick={()=> table.setPageIndex(totalPages - 1)} 
                        className="rounded-none"
                    >
                        Ultimo

                    </Button>
                </li>
            </ul>
  )
}
