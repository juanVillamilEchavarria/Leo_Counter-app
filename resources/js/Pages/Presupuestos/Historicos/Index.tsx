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
import SectionDescriptionWithDetails from "@/app/shared/components/common/SectionDescriptionWithDetails"

export default function Index() {
  const descriptionItems=[
    {
      title: 'Consulta el historial de tus presupuestos',
      description: 'Revisa el historial completo de tus presupuestos para tener un control total sobre tus finanzas',
      icon: 'fa-solid fa-clock-rotate-left !text-yellow-300'

    },
    {
      icon: 'fa-solid fa-chart-line !text-green-400',
      title: 'Filtra por parametros',
      description: 'Filtra tus presupuestos por categoria o monto para encontrar lo que buscas',
    }

  ]
  return (
    <SectionTransition>
        <SectionDescriptionWithDetails
         principalTitle="Presupuestos Historicos" 
         paragraph="Mira Tus Presupuestos Historicos" 
         items={descriptionItems}
         />
        <PresupuestoHistoricoTable />
    </SectionTransition>
  )
}
