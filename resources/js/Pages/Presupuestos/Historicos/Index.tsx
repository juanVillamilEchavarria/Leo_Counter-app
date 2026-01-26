import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { Link } from "@inertiajs/react"
import { PresupuestoHistoricoTable } from "@/app/domains/presupuestoHistorico"
export default function Index() {
  return (
    <SectionTransition>
        <SectionDescription title="Presupuestos Historicos" paragraph="Mira Tus Presupuestos Historicos" />
        <PresupuestoHistoricoTable />
    </SectionTransition>
  )
}
