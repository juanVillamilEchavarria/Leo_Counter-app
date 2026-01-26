import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { PagoPendienteTable } from "@/app/domains/pagoPendiente"
import { Link } from "@inertiajs/react"
export default function Index() {
  return (
    <SectionTransition>
        <SectionDescription title="Pagos Pendientes" paragraph="Gestiona Tus Pagos Pendientes" />
        <CreateButtonSection>
          <CrudButton
            as={Link}
            href="#"
            icon="fa-solid fa-wallet "
            />
        </CreateButtonSection>
        <PagoPendienteTable />
    </SectionTransition>
  )
}
