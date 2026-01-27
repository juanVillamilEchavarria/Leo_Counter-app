import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { Link } from "@inertiajs/react"
import { PresupuestoPorPeriodoTable } from "@/app/domains/presupuestoPorPeriodo"
import { PresupuestoPorPeriodoRoutes, type PresupuestoPorPeriodoTableData } from "@/app/domains/presupuestoPorPeriodo"

export default function Index({
    presupuestos
}: {
    presupuestos: { data: PresupuestoPorPeriodoTableData[] }
}) {
    return (
        <SectionTransition>
            <SectionDescription 
                title="Presupuestos Por Período" 
                paragraph="Gestiona tus presupuestos por periodos poco comunes (semestrales, trimestrales, anuales, etc)"
            />
            <CreateButtonSection>
                <CrudButton
                    as={Link}
                    href={PresupuestoPorPeriodoRoutes.create()}
                    icon="fa-solid fa-calendar"
                >
                </CrudButton>
            </CreateButtonSection>
            <PresupuestoPorPeriodoTable data={presupuestos.data} />
        </SectionTransition>
    )
}
