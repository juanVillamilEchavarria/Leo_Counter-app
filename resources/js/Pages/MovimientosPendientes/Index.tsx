import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { MovimientoPendienteTable } from "@/app/domains/movimientoPendiente"
import { Link } from "@inertiajs/react"
export default function Index() {
  return (
    <SectionTransition>
        <SectionDescription title="Movimientos Pendientes" paragraph="Gestiona Tus Movimientos Pendientes" />
        <CreateButtonSection>
          <CrudButton
            as={Link}
            href="#"
            icon="fa-solid fa-wallet "
            />
        </CreateButtonSection>
        <MovimientoPendienteTable />
    </SectionTransition>
  )
}
