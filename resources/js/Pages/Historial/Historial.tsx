import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { HistorialTable } from "@/app/domains/historial"
export default function Historial() {
  return (
    <SectionTransition>
        <SectionDescription title="Historial" paragraph="Mira Quien Cambio Que" />
        <HistorialTable />
        
    </SectionTransition>
  )
}
