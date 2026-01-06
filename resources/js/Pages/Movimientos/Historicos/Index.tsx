import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SimpleTanStackTable from "@/app/shared/components/table/SimpleTanStackTable"
import CrudButton from "@/app/shared/components/common/CrudButton"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import { Link } from "@inertiajs/react"
export default function Index() {
  return (
    <div className="section">
        <SectionDescription title="Movimientos Historicos" paragraph="Mira Tus Movimientos Historicos" />
        <CreateButtonSection>
          <CrudButton
                as={Link}
                href="#"
                icon="fa-solid fa-earth-americas "
                />
        </CreateButtonSection>
        <SimpleTanStackTable />
         
    </div>
  )
}
