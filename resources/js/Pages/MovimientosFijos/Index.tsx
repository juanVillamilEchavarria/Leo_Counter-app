import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import { MovimientoFijoTable } from "@/app/domains/movimientoFijo"
import { Link } from "@inertiajs/react"

export default function Index() {
  return (
    <div className="section">
        <SectionDescription title="Movimientos Fijos" paragraph="Gestiona Tus Movimientos Fijos" />
        <CreateButtonSection>
          <CrudButton
                as={Link}
                href="#"
                icon="fa-solid fa-diagram-project "
                />
        </CreateButtonSection>
        <MovimientoFijoTable />
    </div>
  )
}
