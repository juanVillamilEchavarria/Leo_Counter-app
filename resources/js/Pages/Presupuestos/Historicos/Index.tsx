import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { PresupuestoHistoricoTable } from "@/app/domains/presupuestoHistorico"

export default function Index() {
  return (
    <SectionTransition>
        <SectionDescription title="Presupuestos Historicos" paragraph="Mira Tus Presupuestos Historicos" />
        <PresupuestoHistoricoTable />
    </SectionTransition>
  )
}
