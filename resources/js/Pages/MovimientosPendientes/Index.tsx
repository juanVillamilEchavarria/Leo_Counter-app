import SectionDescription from "@/app/shared/components/common/SectionDescription"
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
  return (
    <SectionTransition>
        <SectionDescription title="Movimientos Pendientes" paragraph="Gestiona tus movimientos pendientes de pago" />
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
                    paragraph={`¿Esta seguro de eliminar el Movimiento Pendiente con ID: ${item?.id} ?`}
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