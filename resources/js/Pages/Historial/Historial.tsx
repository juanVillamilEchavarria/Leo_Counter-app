import SectionDescription from "@/app/shared/components/common/SectionDescription"
import { HistorialTable } from "@/app/domains/historial"
export default function Historial() {
  return (
    <div className="section">
        <SectionDescription title="Historial" paragraph="Mira Quien Cambio Que" />
        <HistorialTable />
        
    </div>
  )
}
