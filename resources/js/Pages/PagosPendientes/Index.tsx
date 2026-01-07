import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import { PagoPendienteTable } from "@/app/domains/pagoPendiente"
import { Link } from "@inertiajs/react"
export default function Index() {
  return (
    <div className=" section">
        <SectionDescription title="Pagos Pendientes" paragraph="Gestiona Tus Pagos Pendientes" />
        <CreateButtonSection>
          <CrudButton
            as={Link}
            href="#"
            icon="fa-solid fa-wallet "
            />
        </CreateButtonSection>
        <PagoPendienteTable />
    </div>
  )
}
