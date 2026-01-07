import Button from "../common/Button"
import { type TablePaginationProps } from "../../types/components"
import { useMemo } from "react"
import { getVisiblePages } from "../../helpers"

// el elemento padre define donde se coloca la paginacion
export default function TablePagination({
    controller,
    maxVisible=5
}:TablePaginationProps){
    const notAllowedStyles = `cursor-not-allowed! text-gray-300!`
      const Pagination= useMemo(()=>{ //se usa useMemo para optimizar el renderizado de la paginacion 
        return getVisiblePages(controller.page, controller.totalPages, maxVisible)
    }, [controller.totalPages, controller.page, maxVisible]) // se actualiza cuando la pagina cambia, o el total de paginas cambia
    const {pages, start, end}= Pagination 
  return (
            <ul className="w-1/4 flex rounded-2xl">
                <li className="mr-3">
                    <Button 
                        variant="primaryPagination" 
                        onClick={()=> controller.goTo(0)} 
                        disabled={!controller.canPrev}
                        className={`rounded-none ${!controller.canPrev && notAllowedStyles}`}
                    >
                        Primer

                    </Button>
                </li>
                <div className="flex ">
                    <li className="">
                        <Button 
                            variant="primaryPagination" 
                            disabled={!controller.canPrev}
                            onClick={()=> controller.prev()} 
                            className={`rounded-none px-3 ${!controller.canPrev && notAllowedStyles}`}
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
                    {pages.map((p) => (
                        <li key={p} className="">
                            <Button 
                                variant="primaryPagination" 
                                onClick={()=> controller.goTo(p)} 
                                className={`
                                    rounded-none 
                                    w-10!
                                    ${p === controller.page ?
                                    'border-blue-500! text-blue-400!' 
                                    : ''}
                            `}>
                                {p + 1}

                            </Button>
                        </li>
                    ))}
        
                    {end < controller.totalPages - 1 && <li className="">
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
                            disabled={!controller.canNext}
                            onClick={()=> controller.next()} 
                            className={`rounded-none px-3 ${!controller.canNext && notAllowedStyles}`}
                            
                        >
                            <i className="fa-regular fa-circle-right "></i>
                        </Button>
                    </li>
        
                </div>
            
                    
                    <li className="mr-3">
                    <Button 
                        variant="primaryPagination" 
                        onClick={()=> controller.goTo(controller.totalPages-1)} 
                        disabled={!controller.canNext}
                        className={`rounded-none ${!controller.canNext && notAllowedStyles}`}
                    >
                        Ultimo

                    </Button>
                </li>
            </ul>
  )
}
