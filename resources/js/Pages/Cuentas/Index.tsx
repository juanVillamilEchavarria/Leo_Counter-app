import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CuentaTable from "@/app/domains/cuenta/components/CuentaTable"
import { Link } from "@inertiajs/react"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { CuentaRoutes } from "@/app/domains/cuenta"
import {  type Cuenta } from "@/app/domains/cuenta"
export default function Index({
  cuentas
}:{
  cuentas : {data: Cuenta[]}
}) {
  console.log(cuentas)
  return (
    <SectionTransition>
        <SectionDescription title="Cuentas" paragraph="Registra las cuentas de tu hogar y gestionalas " />
       <CreateButtonSection>
          <CrudButton
            as={Link}
            href={CuentaRoutes.create()}
            icon="fa-solid fa-wallet "
            />
        </CreateButtonSection>
        
        <div className="overflow-scroll scrollbar-modern">
            <CuentaTable data={cuentas.data} />
        </div>
    </SectionTransition>
  )
}
