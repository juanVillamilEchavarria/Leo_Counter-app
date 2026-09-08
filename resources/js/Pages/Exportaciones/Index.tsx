/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */
import SectionDescriptionWithDetails from '@/app/shared/components/common/SectionDescriptionWithDetails';
import SectionTransition from '@/app/shared/components/common/SectionTransition';
import ExportacionTable from '@/app/domains/exportacion/components/ExportacionTable';

export default function Index() {
  const descriptionItems = [
    {
      title: 'Historial completo de exportaciones',
      description: 'Revisa todas las exportaciones realizadas por los usuarios del sistema',
      icon: 'fa-solid fa-clock-rotate-left !text-yellow-300',
    },
    {
      title: 'Filtra por parámetros',
      description: 'Filtra las exportaciones por usuario, tabla, formato o fecha para encontrar registros específicos',
      icon: 'fa-solid fa-filter !text-green-400',
    },
    {
      title: 'Auditoría y control',
      description: 'Monitorea qué datos se están exportando y por quién, manteniendo la trazabilidad del sistema',
      icon: 'fa-solid fa-shield-halved !text-blue-400',
    },
  ];

  return (
    <SectionTransition>
      <SectionDescriptionWithDetails
        principalTitle="Historial de Exportaciones"
        paragraph="Consulta el registro de todas las exportaciones realizadas en el sistema"
        items={descriptionItems}
      />
      <ExportacionTable />
    </SectionTransition>
  );
}