import { MovimientoEspontaneoTable, type MovimientoEspontaneoTableData, MovimientoEspontaneoRoutes } from "@/app/domains/movimientoEspontaneo"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import { Link } from "@inertiajs/react"
import { dateFormat } from "@/app/shared/helpers"
export default function Index({
    dia,
    movimientos
}:{
    dia: string
    movimientos: {data:MovimientoEspontaneoTableData []}
}) {
  return (
        <SectionTransition>
            <SectionDescription title="Movimientos Espontaneos" paragraph={(
                <p>Gestiona tus movimientos del dia de hoy <span className="font-bold">{dateFormat(dia)}</span></p>
            )} />
            <CreateButtonSection>
                <CrudButton
                    as={Link}
                    href={MovimientoEspontaneoRoutes.create()}
                    icon="fa-solid fa-calendar-day"
                >
                </CrudButton>
            </CreateButtonSection>
            <MovimientoEspontaneoTable data={movimientos.data} onSelect={(item)=> {}} />
        </SectionTransition>
  )
}
