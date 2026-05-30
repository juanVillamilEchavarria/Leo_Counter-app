/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
