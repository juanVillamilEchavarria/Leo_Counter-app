import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CuentasTable from "@/app/domains/cuenta/components/CuentasTable"
import { Link } from "@inertiajs/react"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
Link
export default function Index() {
  return (
    <div className="section">
      
        <SectionDescription title="Cuentas" paragraph="Gestiona Tus Cuentas" />
       <CreateButtonSection>
          <CrudButton
            as={Link}
            href="#"
            icon="fa-solid fa-wallet "
            />
        </CreateButtonSection>
        
        <div className="overflow-scroll scrollbar-modern">
            <CuentasTable />
        </div>
    </div>
  )
}
