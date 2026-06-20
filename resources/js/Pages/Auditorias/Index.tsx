/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import SectionDescriptionWithDetails from "@/app/shared/components/common/SectionDescriptionWithDetails"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import AuditoriaTable from "@/app/domains/auditoria/components/AuditoriaTable"

export default function Index() {
  const descriptionItems = [
    {
      title: 'Auditorías',
      description: 'Revisa las acciones registradas en el sistema para propósitos de auditoría y trazabilidad',
      icon: 'fa-solid fa-shield-halved !text-indigo-400'
    },
    {
      icon: 'fa-solid fa-clock-rotate-left !text-yellow-300',
      title: 'Histórico completo',
      description: 'Consulta todas las acciones registradas con filtros y paginación server-side'
    }
  ]

  return (
    <SectionTransition>
      <SectionDescriptionWithDetails
        principalTitle="Auditorías"
        paragraph="Listado de acciones auditable del sistema"
        items={descriptionItems}
      />

      <AuditoriaTable />
    </SectionTransition>
  )
}
