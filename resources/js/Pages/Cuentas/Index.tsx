import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CuentasTable from "@/app/domains/cuenta/components/CuentasTable"
import { Link } from "@inertiajs/react"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import { CuentaRoutes } from "@/app/domains/cuenta"
export default function Index() {
  return (
    <div className="section">
      
        <SectionDescription title="Cuentas" paragraph="Registra las cuentas de tu hogar y gestionalas " />
       <CreateButtonSection>
          <CrudButton
            as={Link}
            href={CuentaRoutes.create()}
            icon="fa-solid fa-wallet "
            />
        </CreateButtonSection>
        
        <div className="overflow-scroll scrollbar-modern">
            <CuentasTable />
        </div>
    </div>
  )
}
