import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import { MovimientoFijoTable } from "@/app/domains/movimientoFijo"
import { Link } from "@inertiajs/react"
import { MovimientoFijoRoutes } from "@/app/domains/movimientoFijo"
import { type MovimientoFijoTableData } from "@/app/domains/movimientoFijo"

export default function Index({
  movimientos
}:{
  movimientos: {data: MovimientoFijoTableData[]}
}) {
  return (
    <div className="section">
        <SectionDescription title="Movimientos Fijos" paragraph="Gestiona tus ingresos o gastos fijos " />
        <CreateButtonSection>
          <CrudButton
                as={Link}
                href={MovimientoFijoRoutes.create()}
                icon="fa-solid fa-diagram-project "
                />
        </CreateButtonSection>
        <MovimientoFijoTable data={movimientos.data} />
    </div>
  )
}
