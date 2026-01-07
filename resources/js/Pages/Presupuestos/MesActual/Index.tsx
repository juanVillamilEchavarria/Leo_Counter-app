import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import { Link } from "@inertiajs/react"
import { PresupuestoMesActualTable } from "@/app/domains/presupuestoMesActual"
import { dateFormat } from "@/app/shared/helpers"
export default function Index({
    fechaInicio,
    fechaFin
}:{
    fechaInicio: Date | string,
    fechaFin: Date | string
}) {
  return (
    <div className="section">
        <SectionDescription title="Presupuestos Del Mes" paragraph={`${dateFormat(fechaInicio)} - ${dateFormat(fechaFin)}`} />
        <CreateButtonSection>
          <CrudButton
          as={Link}
          href="#"
          icon="fa-solid fa-calendar-day"
          >
          </CrudButton>
        </CreateButtonSection>

        <PresupuestoMesActualTable />

    </div>
  )
}
