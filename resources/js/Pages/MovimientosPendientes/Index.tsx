import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { MovimientoPendienteTable } from "@/app/domains/movimientoPendiente"
import { Link } from "@inertiajs/react"
import { MovimientoPendienteRoutes } from "@/app/domains/movimientoPendiente"
import { type MovimientoPendienteTableData } from "@/app/domains/movimientoPendiente"

export default function Index({
  movimientos
}:{
  movimientos: {data: MovimientoPendienteTableData[]}
}) {
  return (
    <SectionTransition>
        <SectionDescription title="Movimientos Pendientes" paragraph="Gestiona tus movimientos pendientes de pago" />
        <CreateButtonSection>
          <CrudButton
                as={Link}
                href={MovimientoPendienteRoutes.create()}
                icon="fa-solid fa-hourglass-end"
                />
        </CreateButtonSection>
        <MovimientoPendienteTable data={movimientos.data} />
    </SectionTransition>
  )
}
