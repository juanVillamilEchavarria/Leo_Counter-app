import { Sheet, SheetContent, SheetTrigger, SheetClose, SheetDescription, SheetHeader, SheetTitle, SheetFooter } from "@/app/shared/components/ui/sheet"
import Button from "@/app/shared/components/common/Button"
import ReporteForm from "./ReporteForm"

export default function ReporteSheet() {
  return (
    <Sheet>
        <SheetTrigger>
         <Button variant="successSecondary"><i className="fa-solid fa-chart-line"></i> Generar</Button>
        </SheetTrigger>
        <SheetContent className="layout-background flex flex-col ">
            <SheetHeader>
              <SheetTitle className="text-gray-900">Generar Reporte</SheetTitle>
                <SheetDescription>Realiza los filtros para generar un reporte detallado de tu actividad financiera</SheetDescription>
            </SheetHeader>
            <div className="my-5">
               <ReporteForm/>
            </div>
            <SheetFooter className=" mt-auto flex flex-col! gap-2 w-full">
              <Button type="submit" variant="primary">Generar</Button>

                <SheetClose asChild>
                    <Button variant="gray">Cerrar</Button>
                </SheetClose>
            </SheetFooter>
            
           
        </SheetContent>
        
    </Sheet>
  )
}
