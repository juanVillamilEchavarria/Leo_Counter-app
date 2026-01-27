import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { Link } from "@inertiajs/react"
import { PresupuestoMesActualTable } from "@/app/domains/presupuestoMesActual"
import { PresupuestoMesActualRoutes, type PresupuestoMesActualTableData } from "@/app/domains/presupuestoMesActual"
import { dateFormat } from "@/app/shared/helpers"

export default function Index({
    fechaInicio,
    fechaFin,
    presupuestos
}: {
    fechaInicio: Date | string,
    fechaFin: Date | string,
    presupuestos: { data: PresupuestoMesActualTableData[] }
}) {
    return (
        <SectionTransition>
            <SectionDescription 
                title="Presupuestos Del Mes" 
                paragraph={`${dateFormat(fechaInicio)} - ${dateFormat(fechaFin)}`} 
            />
            <CreateButtonSection>
                <CrudButton
                    as={Link}
                    href={PresupuestoMesActualRoutes.create()}
                    icon="fa-solid fa-calendar-day"
                >
                </CrudButton>
            </CreateButtonSection>
            <PresupuestoMesActualTable data={presupuestos.data} />
        </SectionTransition>
    )
}
