/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
import SectionDescriptionWithDetails from "@/app/shared/components/common/SectionDescriptionWithDetails"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import AuditoriaTable from "@/app/domains/auditoria/components/AuditoriaTable"

export default function Index() {
  const descriptionItems = [
    {
      title: '¿Qué son las auditorias?',
      description: 'Mira los registros completos de las acciones en el sistema en los modulos de Movimientos, Movimientos Pendientes y presupuestos, cuando algun usuario cree un nuevo registro, edite alguno ya existente o elimine, quedara aqui la informacion guardada de la accion con detalles',
      icon: 'fa-solid fa-shield-halved !text-indigo-400'
    },
    {
      icon: 'fa-solid fa-magnifying-glass !text-yellow-300',
      title: 'Filtrado dinamico',
      description: 'Filtra tus auditorias por fecha, usuario o modulo para encontrar lo que buscas'
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
