/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { Sheet,SheetTrigger } from "@/app/shared/components/ui/sheet"
import Button from "@/app/shared/components/common/Button"
import ReporteSheetContent from "./ReporteSheetContent"
import { useOpen } from "@/app/shared/hooks"
import { type SetActiveReportFilters } from "../../hooks/Charts/useActiveReportFilters"
import type { Dispatch, SetStateAction } from "react"
import type { ReporteApiResponse } from "../../types/reporte.types"

export interface ReporteSheetProps {
  setData: Dispatch<SetStateAction<ReporteApiResponse>>
  setIsLoading: Dispatch<SetStateAction<boolean>>,
  setError: Dispatch<SetStateAction<any>>
  setActiveReportFilters: SetActiveReportFilters
}
export default function ReporteSheet({
  setData,
  setIsLoading,
  setError,
  setActiveReportFilters
}: ReporteSheetProps) {

  const {isOpen, setIsOpen}= useOpen(false)
  return (
    <Sheet open={isOpen} onOpenChange={setIsOpen}  >
        <SheetTrigger>
         <Button type="button"  variant="successSecondary"><i className="fa-solid fa-chart-line"></i> Generar</Button>
        </SheetTrigger>
        {isOpen && <ReporteSheetContent setActiveReportFilters={setActiveReportFilters} setData={setData} setIsLoading={setIsLoading} setError={setError} />}
       
        
    </Sheet>
  )
}
