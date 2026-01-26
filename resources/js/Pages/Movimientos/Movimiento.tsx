import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { MovimientoTable } from "@/app/domains/movimiento"
import CrudButton from "@/app/shared/components/common/CrudButton"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import { Link } from "@inertiajs/react"
export default function Movimiento() {
  return (
    <SectionTransition>
        <SectionDescription title="Movimientos" paragraph="Mira el historial de tus ingresos y gastos" />
        <MovimientoTable />
    </SectionTransition>
  )
}
