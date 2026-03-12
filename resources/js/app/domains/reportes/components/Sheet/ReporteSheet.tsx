import { Sheet,SheetTrigger } from "@/app/shared/components/ui/sheet"
import Button from "@/app/shared/components/common/Button"
import ReporteSheetContent from "./ReporteSheetContent"
import { useOpen } from "@/app/shared/hooks"

export default function ReporteSheet() {

  const {isOpen, setIsOpen}= useOpen(false)
  return (
    <Sheet open={isOpen} onOpenChange={setIsOpen} >
        <SheetTrigger>
         <Button type="button"  variant="successSecondary"><i className="fa-solid fa-chart-line"></i> Generar</Button>
        </SheetTrigger>
        {isOpen && <ReporteSheetContent />}
       
        
    </Sheet>
  )
}
