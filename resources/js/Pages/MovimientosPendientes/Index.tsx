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
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import{ MarkAsDoneModal, ShowMovimientoPendienteModal} from "@/app/domains/movimientoPendiente"
import { MovimientoPendienteTable } from "@/app/domains/movimientoPendiente"
import { Link } from "@inertiajs/react"
import { useModalItem } from "@/app/shared/hooks"
import {useMovimientoPendiente} from "@/app/domains/movimientoPendiente"
import { MovimientoPendienteRoutes } from "@/app/domains/movimientoPendiente"
import { type MovimientoPendienteTableData } from "@/app/domains/movimientoPendiente"
import type { MovimientoPendienteShowData } from "@/app/domains/movimientoPendiente/types/movimientoPendiente.types"
import { useEffect } from "react"
import SectionDescriptionWithDetails from "@/app/shared/components/common/SectionDescriptionWithDetails"

export default function Index({
  movimientos,
  data
}:{
  movimientos: {data: MovimientoPendienteTableData[]}
  data ?: {data: MovimientoPendienteShowData}
}) {
  useEffect(()=>{
    if(data){
      setItem(data.data)
    }
  },[data])
  const {item, modal, open, close, setItem}= useModalItem<MovimientoPendienteShowData>()
  const {handleSubmit}= useMovimientoPendiente({method: 'delete', id: item?.id})
  const descriptionItems=[
    {
      title: '¿Que son los movimientos pendientes?',
      description: 'Los movimientos pendiente son aquellos movimientos que aun no han sido registrados en tu historial de movimientos, pero que ya conoces que vas a tener que registrarlos en algun momento, normalmente se refieren a gastos o ingresos que se realizaran una sola vez en el futuro',
      icon: 'fa-solid fa-hourglass-half !text-yellow-400'
    },
    {
      title: 'Marca tus movimientos pendientes como registrados',
      description: 'Cuando registres un movimiento pendiente, este se registrara en tu historial de movimientos, para que puedas llevar un control total sobre tus finanzas. Para marcar un movimiento pendiente como registrado haz click en el icono verde que aparece en la tabla de movimientos pendientes,asi de sencillo.',
      icon: 'fa-solid fa-cash-register !text-green-400'
    },
    {
      title: 'Registros vencidos',
      description: 'Si tienes movimientos pendientes con fecha programada anterior a la fecha actual, estos se marcaran como vencidos y se eliminaran automaticamente del sistema, posterior a eso recibiras un correo notificandote al respecto de esta accion ',
      icon: 'fa-solid fa-triangle-exclamation !text-red-400'
    },
    {

      icon: 'fa-solid fa-coins !text-red-400',
      title: 'Cuenta sin saldo suficiente',
      description: 'Si la cuenta asociada al movimiento pendiente de tipo gasto no tiene saldo suficiente para llevar a cabo la transaccion, veras este icono en el nombre de la cuenta del registro, ademas de que estara deshabilitado el boton de marcar como registrado',
    }
  ]
  return (
    <SectionTransition>
        <SectionDescriptionWithDetails 
        principalTitle="Movimientos Pendientes" 
        paragraph="Gestiona tus movimientos pendientes de pago"
        items={descriptionItems} 
        />
        <CreateButtonSection>
          <CrudButton
                as={Link}
                href={MovimientoPendienteRoutes.create()}
                icon="fa-solid fa-hourglass-end"
                />
        </CreateButtonSection>
        <MovimientoPendienteTable data={movimientos.data} onSelect={(item, modal)=>open(item,modal)} />
           <DeleteModal
                    open={item !== null && modal === 'delete'}
                    spanTitle="Eliminar"
                    title='Movimiento Pendiente'
                    onClose={close}
                    paragraph={<p>¿Esta seguro de eliminar el Movimiento Pendiente con el nombre : <span className="font-bold">{item?.nombre}</span> ?</p>}
                    onSubmit={handleSubmit}
                  >
                <span>Los movimientos pendientes eliminados estaran en la configuracion del sistema</span>
              </DeleteModal>
              <MarkAsDoneModal 
              open={item !== null && modal === 'markAsDone'}
              onClose={close}
              onSubmit={close}
              itemSelected={item}
              />
              <ShowMovimientoPendienteModal
              open={item !== null && modal === 'show'}
                movimiento={item}
                onClose={close}
              />
    </SectionTransition>
  )
}