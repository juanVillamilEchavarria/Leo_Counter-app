import SectionDescription from "@/app/shared/components/common/SectionDescription"

import SectionTransition from "@/app/shared/components/common/SectionTransition"

import { PresupuestoHistoricoTable, type PresupuestoHistoricoProps } from "@/app/domains/presupuestoHistorico"

export default function Index({ presupuestos }: PresupuestoHistoricoProps) {
  console.log(presupuestos)
  return (
    <SectionTransition>
        <SectionDescription title="Presupuestos Historicos" paragraph="Mira Tus Presupuestos Historicos" />
        <PresupuestoHistoricoTable data={presupuestos.data} />
    </SectionTransition>
  )
}
