import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CuentasTable from "@/app/domains/cuenta/components/CuentasTable"
import { Link } from "@inertiajs/react"
import CrudButton from "@/app/shared/components/common/CrudButton"
Link
export default function Index() {
  return (
    <div className="section">
      
        <SectionDescription title="Cuentas" paragraph="Gestiona Tus Cuentas" />
        <div className="w-full flex justify-center lg:justify-end my-2">
          <div className="border-b-2 border-green-800 flex flex-col" >
            <CrudButton
            as={Link}
            href="#"
            icon="fa-solid fa-wallet "
            />
        </div>

        </div>
        
        <div className="overflow-scroll scrollbar-modern">
            <CuentasTable />
        </div>
    </div>
  )
}
