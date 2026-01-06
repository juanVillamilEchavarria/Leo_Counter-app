import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SimpleTanStackTable from "@/app/shared/components/table/SimpleTanStackTable"
import { ColumnsTableMovimientosHistoricos } from "@/app/domains/movimiento"
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
        <SimpleTanStackTable
        columns={ColumnsTableMovimientosHistoricos}
        data={[
          {
            id: 1,
            nombre: 'Juan'
          }
        ]}
         />
    </div>
  )
}
