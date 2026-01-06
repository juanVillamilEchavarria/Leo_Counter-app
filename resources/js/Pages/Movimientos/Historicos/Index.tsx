import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SimpleTanStackTable from "@/app/shared/components/table/SimpleTanStackTable"

export default function Index() {
  return (
    <div className="section">
        <SectionDescription title="Movimientos Historicos" paragraph="Mira Tus Movimientos Historicos" />
        <SimpleTanStackTable />
    </div>
  )
}
