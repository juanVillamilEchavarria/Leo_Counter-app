/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.1
 */
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { MovimientoFijoTable } from "@/app/domains/movimientoFijo"
import { Link } from "@inertiajs/react"
import { MovimientoFijoRoutes } from "@/app/domains/movimientoFijo"
import { type MovimientoFijoTableData } from "@/app/domains/movimientoFijo"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import { useModalItem } from "@/app/shared/hooks"
import useMovimientoFijo from "@/app/domains/movimientoFijo/hooks/useMovimientoFijo"
import SectionDescriptionWithDetails from "@/app/shared/components/common/SectionDescriptionWithDetails"

export default function Index({
  movimientos
}:{
  movimientos: {data: MovimientoFijoTableData[]}
}) {
  const {item, modal, open, close}= useModalItem<MovimientoFijoTableData>()
  const {handleSubmit}= useMovimientoFijo({method: 'delete', id: item?.id})
  const descriptionItems=[
    {
      title: '¿Que son los movimientos fijos?',
      description: 'los movimientos fijos son "plantillas" de movimientos que se repiten cada cierto tiempo, como el pago de servicios, el alquiler, o tu sueldo, registra tus movimientos fijos para no tener que volver a escribirlos cada vez que los pagues',
      icon: 'fa-solid fa-clipboard-list !text-yellow-400'
    },
    {
      title : 'Registrado automatico de movimientos',
      description: 'Marca tu movimiento fijo como registro automatico para que cada vez que se cumpla la fecha, este se registre automaticamente en tu historial de movimientos, para que no tengas que preocuparte por olvidar registrar tus gastos o ingresos recurrentes (si no marcas el registro automatico, se registrara en movimientos pendientes, para que puedas registrarlo manualmente cuando quieras)',
      icon: 'fa-solid fa-repeat !text-green-400'
    },
    {
      title: 'Activo e inactivo',
      description: 'Marca tus movimientos fijos como activos o inactivos, los movimientos fijos inactivos no se registraran en tu historial de movimientos, pero no se eliminaran, para que puedas volver a activarlos cuando quieras, asi puedes mantener un historial de tus movimientos fijos aunque ya no los uses',
      icon: 'fa-solid fa-toggle-on !text-blue-400'
    }
  ]

  return (
    <SectionTransition>
        <SectionDescriptionWithDetails 
        principalTitle="Movimientos Fijos" 
        paragraph="Gestiona tus ingresos o gastos fijos "
          items={descriptionItems}
         />
        <CreateButtonSection>
          <CrudButton
                as={Link}
                href={MovimientoFijoRoutes.create()}
                icon="fa-solid fa-diagram-project "
                />
        </CreateButtonSection>
        <MovimientoFijoTable data={movimientos.data} onSelect={(item, modalType)=>open(item,modalType)} />
        
        <DeleteModal
          open={item !== null && modal === 'delete'}
          spanTitle="Eliminar"
          title='Movimiento Fijo'
          onClose={close}
          paragraph={<p>¿Esta seguro de eliminar el Movimiento Fijo con el nombre <span className="font-bold">{item?.nombre}</span>?</p>}
          onSubmit={handleSubmit}
        >
          <small>Los Movimientos fijos eliminados no se pueden recuperar, solo los movimientos fijos sin movimientos asociados pueden ser eliminados, si no lo usaras mas, mejor marcalo como inactivo</small>
        </DeleteModal>
    </SectionTransition>
  )
}
